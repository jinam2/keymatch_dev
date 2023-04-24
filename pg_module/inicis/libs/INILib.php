<?php

/**
 * Copyright (C) 2007 INICIS Inc.
 *
 * \xED빐\xEB떦 \xEB씪\xEC씠釉뚮윭由щ뒗 \xEC젅\xEB\x8C \xEC닔\xEC젙\xEB릺\xEC뼱\xEC꽌\xEB뒗 \xEC븞\xEB맗\xEB땲\xEB떎.
 * \xEC엫\xEC쓽濡\x9C \xEC닔\xEC젙\xEB맂 肄붾뱶\xEC뿉 \xEB\x8C\xED븳 梨낆엫\xEC\x9D \xEC쟾\xEC쟻\xEC쑝濡\x9C \xEC닔\xEC젙\xEC옄\xEC뿉寃\x8C \xEC엳\xEC쓬\xEC쓣 \xEC븣\xEB젮\xEB뱶由쎈땲\xEB떎.
 *
 */
require_once('INICls.php');
require_once('INISoc.php');

class INIpay50 {

    var $m_type;     // 嫄곕옒 \xEC쑀\xED삎
    var $m_resulterrcode;       // 寃곌낵硫붿꽭吏 \xEC뿉\xEB윭肄붾뱶
    var $m_connIP;
    var $m_cancelRC = 0;
    var $m_Data;
    var $m_Log;
    var $m_Socket;
    var $m_Crypto;
    var $m_REQUEST = array();
    var $m_REQUEST2 = array();
    var $m_RESULT = array();

    function INIpay() {
        $this->UnsetField();
    }

    function UnsetField() {
        unset($this->m_REQUEST);
        unset($this->m_RESULT);
    }

    /* -------------------------------------------------- */
    /* 																									 */
    /* 寃곗젣/痍⑥냼 \xEC슂泥\xAD媛\x92 Set or Add                      */
    /* 																									 */
    /* -------------------------------------------------- */

    function SetField($key, $val) { //Default Entity
        $this->m_REQUEST[$key] = $val;
    }

    function SetXPath($xpath, $val) { //User Defined Entity
        $this->m_REQUEST2[$xpath] = $val;
    }

    /* -------------------------------------------------- */
    /* 																									 */
    /* 寃곗젣/痍⑥냼 寃곌낵媛\x92 fetch                           */
    /* 																									 */
    /* -------------------------------------------------- */

    function GetResult($name) { //Default Entity
        $result = $this->m_RESULT[$name];
        if ($result == "")
            $result = $this->m_Data->GetXMLData($name);
        if ($result == "")
            $result = $this->m_Data->m_RESULT[$name];
        return $result;
    }

    /* -------------------------------------------------- */
    /* 																									 */
    /* 寃곗젣/痍⑥냼 泥섎━ 硫붿씤                              */
    /* 																									 */
    /* -------------------------------------------------- */

    function startAction() {

        /* -------------------------------------------------- */
        /* Overhead Operation                               */
        /* -------------------------------------------------- */
        $this->m_Data = new INIData($this->m_REQUEST, $this->m_REQUEST2);

        /* -------------------------------------------------- */
        /* Log Start																				 */
        /* -------------------------------------------------- */
        $this->m_Log = new INILog($this->m_REQUEST);
        if (!$this->m_Log->StartLog()) {
            $this->MakeTXErrMsg(LOG_OPEN_ERR, "濡쒓렇\xED뙆\xEC씪\xEC쓣 \xEC뿴\xEC닔媛 \xEC뾾\xEC뒿\xEB땲\xEB떎.[" . $this->m_REQUEST["inipayhome"] . "]");
            return;
        }

        /* -------------------------------------------------- */
        /* Logging Request Parameter												 */
        /* -------------------------------------------------- */
        $this->m_Log->WriteLog(DEBUG, $this->m_REQUEST);

        /* -------------------------------------------------- */
        /* Set Type																					 */
        /* -------------------------------------------------- */
        $this->m_type = $this->m_REQUEST["type"];

        /* -------------------------------------------------- */
        /* Check Field																			 */
        /* -------------------------------------------------- */
        if (!$this->m_Data->CheckField()) {
            $err_msg = "\xED븘\xEC닔\xED빆紐\xA9(" . $this->m_Data->m_ErrMsg . ")\xEC씠 \xEB늻\xEB씫\xEB릺\xEC뿀\xEC뒿\xEB땲\xEB떎.";
            $this->MakeTXErrMsg($this->m_Data->m_ErrCode, $err_msg);
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            return;
        }
        $this->m_Log->WriteLog(INFO, "Check Field OK");

        /* -------------------------------------------------- */
        //\xEC쎒\xED럹\xEC씠吏\xEC쐞蹂議곗슜 \xED궎\xEC깮\xEC꽦. \xEC뿬湲곗꽌 \xEB걹!!
        /* -------------------------------------------------- */
        if ($this->m_type == TYPE_CHKFAKE) {
            return $this->MakeChkFake();
        }

        /* -------------------------------------------------- */
        //Generate TID
        /* -------------------------------------------------- */
        if ($this->m_type == TYPE_SECUREPAY || $this->m_type == TYPE_FORMPAY || $this->m_type == TYPE_OCBSAVE ||
                $this->m_type == TYPE_AUTHBILL || $this->m_type == TYPE_FORMAUTH || $this->m_type == TYPE_REQREALBILL ||
                $this->m_type == TYPE_REPAY || $this->m_type == TYPE_VACCTREPAY || $this->m_type == TYPE_RECEIPT || $this->m_type == TYPE_AUTH
        ) {
            if (!$this->m_Data->MakeTID()) {
                $err_msg = "TID\xEC깮\xEC꽦\xEC뿉 \xEC떎\xED뙣\xED뻽\xEC뒿\xEB땲\xEB떎.::" . $this->m_Data->m_sTID;
                $this->m_Log->WriteLog(ERROR, $err_msg);
                $this->MakeTXErrMsg(MAKE_TID_ERR, $err_msg);
                $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
                return;
            }
            $this->m_Log->WriteLog(INFO, 'Make TID OK ' . $this->m_Data->m_sTID);
        }

        $this->m_Crypto = new INICrypto($this->m_REQUEST);

        /* -------------------------------------------------- */
        //PI怨듦컻\xED궎 濡쒕뱶
        /* -------------------------------------------------- */
        $this->m_Data->ParsePIEncrypted();
        $this->m_Log->WriteLog(INFO, "PI PUB KEY LOAD OK [" . $this->m_Data->m_PIPGPubSN . "]");

        /* -------------------------------------------------- */
        //PG怨듦컻\xED궎 濡쒕뱶
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Crypto->LoadPGPubKey($pg_cert_SN)) != OK) {
            $err_msg = "PG怨듦컻\xED궎 濡쒕뱶\xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            return;
        }
        $this->m_Data->m_TXPGPubSN = $pg_cert_SN;
        $this->m_Log->WriteLog(INFO, "PG PUB KEY LOAD OK [" . $this->m_Data->m_TXPGPubSN . "]");

        /* -------------------------------------------------- */
        //\xEC긽\xEC젏媛쒖씤\xED궎 濡쒕뱶
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Crypto->LoadMPrivKey()) != OK) {
            $err_msg = "\xEC긽\xEC젏媛쒖씤\xED궎 濡쒕뱶\xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreePubKey();
            return;
        }
        $this->m_Log->WriteLog(INFO, "MERCHANT PRIV KEY LOAD OK");

        /* -------------------------------------------------- */
        //\xEC긽\xEC젏 怨듦컻\xED궎 濡쒕뱶(SN 瑜\xBC \xEC븣湲곗쐞\xED빐!!)
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Crypto->LoadMPubKey($m_cert_SN)) != OK) {
            $err_msg = "\xEC긽\xEC젏怨듦컻\xED궎 濡쒕뱶\xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            return;
        }
        $this->m_Data->m_MPubSN = $m_cert_SN;
        $this->m_Log->WriteLog(INFO, "MERCHANT PUB KEY LOAD OK [" . $this->m_Data->m_MPubSN . "]");

        /* -------------------------------------------------- */
        //\xED뤌\xED럹\xEC씠 \xEC븫\xED샇\xED솕( formpay, cancel, repay, recept, inquiry, opensub)
        /* -------------------------------------------------- */
        if ($this->m_type == TYPE_CANCEL || $this->m_type == TYPE_REPAY || $this->m_type == TYPE_VACCTREPAY ||
                $this->m_type == TYPE_FORMPAY || $this->m_type == TYPE_RECEIPT ||
                $this->m_type == TYPE_CAPTURE || $this->m_type == TYPE_INQUIRY || $this->m_type == TYPE_OPENSUB ||
                ($this->m_type == TYPE_ESCROW && $this->m_Data->m_EscrowType == TYPE_ESCROW_DLV ) ||
                ($this->m_type == TYPE_ESCROW && $this->m_Data->m_EscrowType == TYPE_ESCROW_DNY_CNF ) ||
                $this->m_type == TYPE_REFUND
        ) {
            if (($rtv = $this->m_Data->MakeEncrypt($this->m_Crypto)) != OK) {
                $err_msg = "\xEC븫\xED샇\xED솕 \xEC삤瑜\x98";
                $this->m_Log->WriteLog(ERROR, $err_msg);
                $this->MakeTXErrMsg($rtv, $err_msg);
                $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
                return;
            }
            //$this->m_Log->WriteLog( DEBUG, "MAKE ENCRYPT OK" );
            $this->m_Log->WriteLog(DEBUG, "MAKE ENCRYPT OK[" . $this->m_Data->m_EncBody . "]");
        }

        /* -------------------------------------------------- */
        //\xEC쟾臾몄깮\xEC꽦(Body)
        /* -------------------------------------------------- */
        $this->m_Data->MakeBody();
        $this->m_Log->WriteLog(INFO, "MAKE BODY OK");
        //$this->m_Log->WriteLog( INFO, "MAKE BODY OK[".$this->m_Data->m_sBody."]" );

        /* -------------------------------------------------- */
        //\xEC꽌紐\x85(sign)
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Crypto->Sign($this->m_Data->m_sBody, $sign)) != OK) {
            $err_msg = "\xEC떥\xEC씤\xEC떎\xED뙣";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreeAllKey();
            return;
        }
        $this->m_Data->m_sTail = $sign;
        $this->m_Log->WriteLog(INFO, "SIGN OK");
        //$this->m_Log->WriteLog( INFO, "SIGN OK[".$sign."]" );

        /* -------------------------------------------------- */
        //\xEC쟾臾몄깮\xEC꽦(Head)
        /* -------------------------------------------------- */
        $this->m_Data->MakeHead();
        $this->m_Log->WriteLog(INFO, "MAKE HEAD OK");
        //$this->m_Log->WriteLog( INFO, "MAKE HEAD OK[".$head."]" );

        $this->m_Log->WriteLog(INFO, "MSG_TO_PG:[" . $this->m_Data->m_sMsg . "]");

        /* -------------------------------------------------- */
        //\xEC냼耳볦깮\xEC꽦
        /* -------------------------------------------------- */
        //DRPG \xEC뀑\xED똿, added 07.11.15
        //痍⑥냼\xEC떆-PG\xEC꽕\xEC젙 蹂寃\xBD(\xEB룄硫붿씤->IP), edited 10.09.09
        if ($this->m_type == TYPE_SECUREPAY) {
            if ($this->m_REQUEST["pgn"] == "")
                $host = $this->m_Data->m_PG1;
            else
                $host = $this->m_REQUEST["pgn"];
        }
        else {
            if ($this->m_REQUEST["pgn"] == "") {
                if ($this->m_cancelRC == 1)
                    $host = DRPG_IP;
                else
                    $host = PG_IP;
            } else
                $host = $this->m_REQUEST["pgn"];
        }

        $this->m_Socket = new INISocket($host);
        if (($rtv = $this->m_Socket->DNSLookup()) != OK) {
            $err_msg = "[" . $host . "]DNS LOOKUP \xEC떎\xED뙣(MAIN)" . $this->m_Socket->getErr();
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            if ($this->m_type == TYPE_SECUREPAY) { //PI\xEC씪寃쎌슦, PI媛 \xEB궡\xEB젮二쇰뒗 pg1ip濡\x9C!
                $this->m_Socket->ip = $this->m_Data->m_PG1IP;
            } else {
                if ($this->m_cancelRC == 1)
                    $this->m_Socket->ip = DRPG_IP;
                else
                    $this->m_Socket->ip = PG_IP;
            }
        }
        $this->m_Log->WriteLog(INFO, "DNS LOOKUP OK(" . $this->m_Socket->host . ":" . $this->m_Socket->ip . ":" . $this->m_Socket->port . ") laptime:" . $this->m_Socket->dns_laptime);
        if (($rtv = $this->m_Socket->open()) != OK) {
            $this->m_Socket->close();

            //PG2濡\x9C \xEC쟾\xED솚
            $err_msg = "[" . $host . "\xEC냼耳볦뿰寃곗삤瑜\x98(MAIN)::PG2濡\x9C \xEC쟾\xED솚";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            if ($this->m_type == TYPE_SECUREPAY) {
                $host = $this->m_Data->m_PG2;
            } else {
                $host = DRPG_HOST;
            }
            $this->m_Socket = new INISocket($host);
            if (($rtv = $this->m_Socket->DNSLookup()) != OK) {
                $err_msg = "[" . $host . "]DNS LOOKUP \xEC떎\xED뙣(MAIN)" . $this->m_Socket->getErr();
                $this->m_Log->WriteLog(ERROR, $err_msg);
                $this->MakeTXErrMsg($rtv, $err_msg);
                if ($this->m_type == TYPE_SECUREPAY) { //PI\xEC씪寃쎌슦, PI媛 \xEB궡\xEB젮二쇰뒗 pg2ip濡\x9C!
                    $this->m_Socket->ip = $this->m_Data->m_PG2IP;
                } else {
                    $this->m_Socket->ip = DRPG_IP;
                }
            }
            $this->m_Log->WriteLog(INFO, "DNS LOOKUP OK(" . $this->m_Socket->host . ":" . $this->m_Socket->ip . ":" . $this->m_Socket->port . ") laptime:" . $this->m_Socket->dns_laptime);
            if (($rtv = $this->m_Socket->open()) != OK) {
                $err_msg = "[" . $host . "\xEC냼耳볦뿰寃곗삤瑜\x98(MAIN)::" . $this->m_Socket->getErr();
                $this->m_Log->WriteLog(ERROR, $err_msg);
                $this->MakeTXErrMsg($rtv, $err_msg);
                $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
                $this->m_Socket->close();
                $this->m_Crypto->FreeAllKey();
                return;
            }
        }
        $this->m_connIP = $this->m_Socket->ip;
        $this->m_Log->WriteLog(INFO, "SOCKET CONNECT OK");

        /* -------------------------------------------------- */
        //\xEC쟾臾몄넚\xEC떊
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Socket->send($this->m_Data->m_sMsg)) != OK) {
            $err_msg = "\xEC냼耳볦넚\xEC떊\xEC삤瑜\x98(MAIN)::" . $this->m_Socket->getErr();
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreeAllKey();
            $this->m_Socket->close();
            return;
        }
        $this->m_Log->WriteLog(INFO, "SEND OK");

        /* -------------------------------------------------- */
        //\xEC쟾臾몄닔\xEC떊
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Socket->recv($head, $body, $tail)) != OK) {
            $err_msg = "\xEC냼耳볦닔\xEC떊\xEC삤瑜\x98(MAIN)::" . $this->m_Socket->getErr();
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Socket->close();
            $this->NetCancel();
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreeAllKey();
            return;
        }
        $this->m_Log->WriteLog(INFO, "RECV OK");
        $this->m_Log->WriteLog(INFO, "MSG_FROM_PG:[" . $head . $body . $tail . "]");
        $this->m_Data->m_Body = $body;

        /* -------------------------------------------------- */
        //\xEC꽌紐낇솗\xEC씤
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Crypto->Verify($body, $tail)) != OK) {
            $err_msg = "VERIFY FAIL";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Socket->close();
            $this->NetCancel();
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreeAllKey();
            return;
        }
        $this->m_Log->WriteLog(INFO, "VERIFY OK");

        /* -------------------------------------------------- */
        //Head \xED뙆\xEC떛
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Data->ParseHead($head)) != OK) {
            $err_msg = "\xEC닔\xEC떊\xEC쟾臾\xB8(HEAD) \xED뙆\xEC떛 \xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Socket->close();
            $this->NetCancel();
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreeAllKey();
            return;
        }
        $this->m_Log->WriteLog(INFO, "PARSE HEAD OK");

        /* -------------------------------------------------- */
        //Body \xED뙆\xEC떛
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Data->ParseBody($body, $encrypted, $sessionkey)) != OK) {
            $err_msg = "\xEC닔\xEC떊\xEC쟾臾\xB8(Body) \xED뙆\xEC떛 \xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Socket->close();
            $this->NetCancel();
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreeAllKey();
            return;
        }
        $this->m_Log->WriteLog(INFO, "PARSE BODY OK");

        /* -------------------------------------------------- */
        //蹂듯샇\xED솕
        /* -------------------------------------------------- */
        if ($this->m_type == TYPE_SECUREPAY || $this->m_type == TYPE_FORMPAY || $this->m_type == TYPE_OCBSAVE ||
                $this->m_type == TYPE_CANCEL || $this->m_type == TYPE_AUTHBILL || $this->m_type == TYPE_FORMAUTH ||
                $this->m_type == TYPE_REQREALBILL || $this->m_type == TYPE_REPAY || $this->m_type == TYPE_VACCTREPAY || $this->m_type == TYPE_RECEIPT ||
                $this->m_type == TYPE_AUTH || $this->m_type == TYPE_CAPTURE || $this->m_type == TYPE_ESCROW ||
                $this->m_type == TYPE_REFUND || $this->m_type == TYPE_INQUIRY || $this->m_type == TYPE_OPENSUB
        ) {
            if (($rtv = $this->m_Crypto->Decrypt($sessionkey, $encrypted, $decrypted)) != OK) {
                $err_msg = "蹂듯샇\xED솕 \xEC떎\xED뙣[" . $this->GetResult(NM_RESULTMSG) . "]";
                $this->m_Log->WriteLog(ERROR, $err_msg);
                $this->MakeTXErrMsg($rtv, $err_msg);
                $this->m_Socket->close();
                $this->NetCancel();
                $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
                $this->m_Crypto->FreeAllKey();
                return;
            }
            $this->m_Log->WriteLog(INFO, "DECRYPT OK");
            $this->m_Log->WriteLog(DEBUG, "DECRYPT MSG:[" . $decrypted . "]");

            //Parse Decrypt
            $this->m_Data->ParseDecrypt($decrypted);
            $this->m_Log->WriteLog(INFO, "DECRYPT PARSE OK");
        }

        /* -------------------------------------------------- */
        //Assign Interface Variables
        /* -------------------------------------------------- */
        $this->m_RESULT = $this->m_Data->m_RESULT;

        /* -------------------------------------------------- */
        //ACK
        /* -------------------------------------------------- */
        //if( $this->GetResult(NM_RESULTCODE) == "00" && 
        if ((strcmp($this->GetResult(NM_RESULTCODE), "00") == 0) &&
                ( $this->m_type == TYPE_SECUREPAY || $this->m_type == TYPE_OCBSAVE ||
                $this->m_type == TYPE_FORMPAY || $this->m_type == TYPE_RECEIPT
                )
        ) {
            $this->m_Log->WriteLog(INFO, "WAIT ACK INVOKING");
            if (($rtv = $this->Ack()) != OK) {
                //ERROR
                $err_msg = "ACK \xEC떎\xED뙣";
                $this->m_Log->WriteLog(ERROR, $err_msg);
                $this->MakeTXErrMsg($rtv, $err_msg);
                $this->m_Socket->close();
                $this->NetCancel();
                $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
                $this->m_Crypto->FreeAllKey();
                return;
            }
            $this->m_Log->WriteLog(INFO, "SUCCESS ACK INVOKING");
        }
        /* -------------------------------------------------- */
        //PG 怨듦컻\xED궎媛 諛붾뚯뿀\xEC쑝硫\xB4 怨듦컻\xED궎 UPDATE
        /* -------------------------------------------------- */
        $pgpubkey = $this->m_Data->GetXMLData(NM_PGPUBKEY);
        if ($pgpubkey != "") {
            if (($rtv = $this->m_Crypto->UpdatePGPubKey($pgpubkey)) != OK) {
                $err_msg = "PG怨듦컻\xED궎 \xEC뾽\xEB뜲\xEC씠\xED듃 \xEC떎\xED뙣";
                $this->m_Log->WriteLog(ERROR, $err_msg);
                $this->m_Data->GTHR($rtv, $err_msg);
            } else
                $this->m_Log->WriteLog(INFO, "PGPubKey UPDATED!!");
        }

        $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
        $this->m_Crypto->FreeAllKey();
        $this->m_Socket->close();

        /* -------------------------------------------------- */
        //痍⑥냼\xEC떎\xED뙣-\xEC썝嫄곕옒\xEC뾾\xEC쓬\xEC떆\xEC뿉 DRPG濡\x9C \xEC옱\xEC떆\xEB룄
        //2008.04.01
        /* -------------------------------------------------- */
        if ($this->GetResult(NM_RESULTCODE) == "01" && ($this->m_type == TYPE_CANCEL || $this->m_type == TYPE_INQUIRY) && $this->m_cancelRC == 0) {
            if (intval($this->GetResult(NM_ERRORCODE)) > 400000 && substr($this->GetResult(NM_ERRORCODE), 3, 3) == "623") {
                $this->m_cancelRC = 1;
                $this->startAction();
            }
        }

        return;
    }

// End of StartAction

    /* -------------------------------------------------- */
    /* 																									 */
    /* \xEC쎒\xED럹\xEC씠吏 \xEC쐞蹂議\xB0 諛⑹\xA7\xEC슜 \xEB뜲\xEC씠\xED\x83 \xEC깮\xEC꽦								 */
    /* 																									 */
    /* -------------------------------------------------- */

    function MakeChkFake() {
        $this->m_Crypto = new INICrypto($this->m_REQUEST);

        /* -------------------------------------------------- */
        //\xEC긽\xEC젏媛쒖씤\xED궎 濡쒕뱶
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Crypto->LoadMPrivKey()) != OK) {
            $err_msg = "\xEC긽\xEC젏媛쒖씤\xED궎 濡쒕뱶\xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Crypto->FreePubKey();
            return;
        }
        $this->m_Log->WriteLog(INFO, "MERCHANT PRIV KEY LOAD OK");

        /* -------------------------------------------------- */
        //\xEC긽\xEC젏 怨듦컻\xED궎 濡쒕뱶(SN 瑜\xBC \xEC븣湲곗쐞\xED빐!!)
        /* -------------------------------------------------- */
        if (($rtv = $this->m_Crypto->LoadMPubKey($m_cert_SN)) != OK) {
            $err_msg = "\xEC긽\xEC젏怨듦컻\xED궎 濡쒕뱶\xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            $this->MakeTXErrMsg($rtv, $err_msg);
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            return;
        }
        $this->m_Log->WriteLog(INFO, "MERCHANT PUB KEY LOAD OK [" . $this->m_Data->m_MPubSN . "]");

        foreach ($this->m_REQUEST as $key => $val) {
            if ($key == "inipayhome" || $key == "type" || $key == "debug" ||
                    $key == "admin" || $key == "checkopt" || $key == "enctype")
                continue;
            if ($key == "mid")
                $temp1 .= $key . "=" . $val . "&"; //msg
            else
                $temp2 .= $key . "=" . $val . "&"; //hashmsg
        }
        //Make RN
        $this->m_RESULT["rn"] = $this->m_Data->MakeRN();
        $temp1 .= "rn=" . $this->m_RESULT["rn"] . "&";

        $checkMsg = $temp1;
        $checkHashMsg = $temp2;

        $retHashStr = Base64Encode(sha1($checkHashMsg, TRUE));
        $checkMsg .= "data=" . $retHashStr;

        $HashMid = Base64Encode(sha1($this->m_REQUEST["mid"], TRUE));

        $this->m_Crypto->RSAMPrivEncrypt($checkMsg, $RSATemp);
        $this->m_RESULT["encfield"] = "enc=" . $RSATemp . "&src=" . Base64Encode($checkHashMsg);
        $this->m_RESULT["certid"] = $HashMid . $m_cert_SN;

        $this->m_Log->WriteLog(INFO, "CHKFAKE KEY MAKE OK:" . $this->m_RESULT["rn"]);

        $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
        $this->m_Crypto->FreeAllKey();
        $this->m_RESULT[NM_RESULTCODE] = "00";
        return;
    }

    /* -------------------------------------------------- */
    /* 																									 */
    /* 寃곗젣泥섎━ \xED솗\xEC씤 硫붿꽭吏 \xEC쟾\xEC넚												 */
    /* 																									 */
    /* -------------------------------------------------- */

    function Ack() {
        //ACK\xEC슜 Data	
        $this->m_Data->m_sBody = "";
        $this->m_Data->m_sTail = "";
        $this->m_Data->m_sCmd = CMD_REQ_ACK;

        //\xEC쟾臾몄깮\xEC꽦(Head)
        $this->m_Data->MakeHead();
        $this->m_Log->WriteLog(DEBUG, "MAKE HEAD OK");
        //$this->m_Log->WriteLog( DEBUG, "MSG_TO_PG:[".$this->m_Data->m_sMsg."]" );
        //Send
        if (($rtv = $this->m_Socket->send($this->m_Data->m_sMsg)) != OK) {
            $err_msg = "ACK \xEC쟾\xEC넚\xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            return ACK_CHECKSUM_ERR;
        }
        //$this->m_Log->WriteLog( DEBUG, "SEND OK" );

        if (($rtv = $this->m_Socket->recv($head, $body, $tail)) != OK) {
            $err_msg = "ACK \xEC닔\xEC떊\xEC삤瑜\x98(ACK)";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            return ACK_CHECKSUM_ERR;
        }
        //$this->m_Log->WriteLog( DEBUG, "RECV OK" );
        //$this->m_Log->WriteLog( INFO, "MSG_FROM_PG:[".$recv."]" );
        return OK;
    }

    /* -------------------------------------------------- */
    /* 																									 */
    /* 留앹랬\xEC냼 硫붿꽭吏 \xEC쟾\xEC넚																 */
    /* 																									 */
    /* -------------------------------------------------- */

    function NetCancel() {
        $this->m_Log->WriteLog(INFO, "WAIT NETCANCEL INVOKING");

        if ($this->m_type == TYPE_CANCEL || $this->m_type == TYPE_REPAY || $this->m_type == TYPE_VACCTREPAY || $this->m_type == TYPE_RECEIPT ||
                $this->m_type == TYPE_CONFIRM || $this->m_type == TYPE_OCBQUERY || $this->m_type == TYPE_ESCROW ||
                $this->m_type == TYPE_CAPTURE || $this->m_type == TYPE_AUTH || $this->m_type == TYPE_AUTHBILL ||
                ($this->m_type == TYPE_ESCROW && $this->m_Data->m_EscrowType == TYPE_ESCROW_DNY_CNF ) ||
                $this->m_type == TYPE_NETCANCEL
        ) {
            $this->m_Log->WriteLog(INFO, "DON'T NEED NETCANCEL");
            return true;
        }

        //NetCancel\xEC슜 Data	
        $this->m_Data->m_REQUEST["cancelmsg"] = "留앹랬\xEC냼";
        $body = "";
        $sign = "";

        $this->m_Data->m_Type = TYPE_CANCEL; //留앹랬\xEC냼 \xEC쟾臾몄\x9D 痍⑥냼\xEC쟾臾멸낵 媛숈쓬.\xED뿤\xEB뜑留뚰\x8B由ш퀬..姨\x9D~
        //added escrow netcancel, 08.03.11
        if ($this->m_type == TYPE_ESCROW && $this->m_Data->m_EscrowType == TYPE_ESCROW_DLV)
            $this->m_Data->m_sCmd = CMD_REQ_DLV_NETC;
        else if ($this->m_type == TYPE_ESCROW && $this->m_Data->m_EscrowType == TYPE_ESCROW_CNF)
            $this->m_Data->m_sCmd = CMD_REQ_CNF_NETC;
        else if ($this->m_type == TYPE_ESCROW && $this->m_Data->m_EscrowType == TYPE_ESCROW_DNY)
            $this->m_Data->m_sCmd = CMD_REQ_DNY_NETC;
        else
            $this->m_Data->m_sCmd = CMD_REQ_NETC;

        $this->m_Data->m_sCrypto = FLAG_CRYPTO_3DES;

        //\xEC븫\xED샇\xED솕
        if (($rtv = $this->m_Data->MakeEncrypt($this->m_Crypto)) != OK) {
            $err_msg = "\xEC븫\xED샇\xED솕 \xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            return;
        }
        $this->m_Log->WriteLog(DEBUG, "MAKE ENCRYPT OK[" . $this->m_Data->m_EncBody . "]");

        //\xEC쟾臾몄깮\xEC꽦(Body)
        $this->m_Data->MakeBody();
        $this->m_Log->WriteLog(INFO, "MAKE BODY OK");

        //\xEC꽌紐\x85(sign)
        if (($rtv = $this->m_Crypto->Sign($this->m_Data->m_sBody, $sign)) != OK) {
            $err_msg = "\xEC떥\xEC씤\xEC떎\xED뙣";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            return false;
        }
        $this->m_Data->m_sTail = $sign;
        $this->m_Log->WriteLog(INFO, "SIGN OK");

        //\xEC쟾臾몄깮\xEC꽦(Head)
        $this->m_Data->MakeHead();
        $this->m_Log->WriteLog(INFO, "MAKE HEAD OK");

        $this->m_Log->WriteLog(DEBUG, "MSG_TO_PG:[" . $this->m_Data->m_sMsg . "]");

        //\xEC냼耳볦깮\xEC꽦
        $this->m_Socket = new INISocket("");
        $this->m_Socket->ip = $this->m_connIP; //湲곗〈\xEC뿰寃곕맂 IP \xEC궗\xEC슜, 08.03.12
        if (($rtv = $this->m_Socket->open()) != OK) {
            $err_msg = "[" . $this->m_Socket->ip . "]\xEC냼耳볦뿰寃곗삤瑜\x98(NETC)::" . $this->m_Socket->getErr();
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            $this->m_Log->CloseLog($this->GetResult(NM_RESULTMSG));
            $this->m_Socket->close();
            $this->m_Crypto->FreeAllKey();
            return;
        }
        $this->m_Log->WriteLog(INFO, "SOCKET CONNECT OK::" . $this->m_Socket->ip);

        //\xEC쟾臾몄넚\xEC떊
        if (($rtv = $this->m_Socket->send($this->m_Data->m_sMsg)) != OK) {
            $err_msg = "\xEC냼耳볦넚\xEC떊\xEC삤瑜\x98(NETC)" . $this->m_Socket->getErr();
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            $this->m_Socket->close();
            return false;
        }
        $this->m_Log->WriteLog(INFO, "SEND OK");

        //\xEC쟾臾몄닔\xEC떊
        if (($rtv = $this->m_Socket->recv($head, $body, $tail)) != OK) {
            $err_msg = "\xEC냼耳볦닔\xEC떊\xEC삤瑜\x98(NETC)";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            $this->m_Socket->close();
            return false;
        }
        $this->m_Log->WriteLog(INFO, "RECV OK");
        $this->m_Log->WriteLog(DEBUG, "MSG_FROM_PG:[" . $head . $body . $tail . "]");

        //\xEC꽌紐낇솗\xEC씤
        if (($rtv = $this->m_Crypto->Verify($body, $tail)) != OK) {
            $err_msg = "VERIFY FAIL";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            $this->m_Socket->close();
            return false;
        }
        $this->m_Log->WriteLog(INFO, "VERIFY OK");

        //\xEC씠\xED븯 \xED뿤\xEB뜑\xEB굹 蹂몃Ц\xEC\x9D \xED뙆\xEC떛\xED븯吏 \xEC븡\xEB뒗\xEB떎!!!!
        //洹몃깷 \xEC뿬湲곗꽌 \xEB걹\xEB궡\xEC옄 \xED뵾怨ㅽ븯\xEB떎.-_-;;
        //Head \xED뙆\xEC떛
        if (($rtv = $this->m_Data->ParseHead($head)) != OK) {
            $err_msg = "\xEC닔\xEC떊\xEC쟾臾\xB8(HEAD) \xED뙆\xEC떛 \xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            $this->m_Socket->close();
            return;
        }
        //Body \xED뙆\xEC떛
        if (($rtv = $this->m_Data->ParseBody($body, $encrypted, $sessionkey)) != OK) {
            $err_msg = "\xEC닔\xEC떊\xEC쟾臾\xB8(Body) \xED뙆\xEC떛 \xEC삤瑜\x98";
            $this->m_Log->WriteLog(ERROR, $err_msg);
            //$this->MakeTXErrMsg( $rtv, $err_msg ); 
            $this->m_Socket->close();
            return;
        }

        //if( $this->GetResult(NM_RESULTCODE) == "00" )
        if (strcmp($this->GetResult(NM_RESULTCODE), "00") == 0)
            $this->m_Log->WriteLog(INFO, "SUCCESS NETCANCEL");
        else
            $this->m_Log->WriteLog(ERROR, "ERROR NETCANCEL[" . $this->GetResult(NM_RESULTMSG) . "]");
        return true;
    }

    function MakeIMStr($s, $t) {
        $this->m_Crypto = new INICrypto($this->m_REQUEST);
        if ($t == "H")
            return $this->m_Crypto->MakeIMStr($s, base64_decode(IMHK));
        else if ($t == "J")
            return $this->m_Crypto->MakeIMStr($s, base64_decode(IMJK));
    }

    /* -------------------------------------------------- */
    /* 																									 */
    /* \xEC뿉\xEB윭硫붿꽭吏 Make				                          */
    /* 																									 */
    /* -------------------------------------------------- */

    function MakeTXErrMsg($err_code, $err_msg) {
        $this->m_RESULT[NM_RESULTCODE] = "01";
        $this->m_RESULT[NM_RESULTERRORCODE] = $err_code;
        $this->m_RESULT[NM_RESULTMSG] = "[" . $err_code . "|" . $err_msg . "]";
        $this->m_Data->GTHR($err_code, $err_msg);
        return;
    }

}

?>
