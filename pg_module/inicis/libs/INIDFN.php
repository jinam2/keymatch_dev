<?php

/**
 * Copyright (C) 2007 INICIS Inc.
 *
 * \xED빐\xEB떦 \xEB씪\xEC씠釉뚮윭由щ뒗 \xEC젅\xEB\x8C \xEC닔\xEC젙\xEB릺\xEC뼱\xEC꽌\xEB뒗 \xEC븞\xEB맗\xEB땲\xEB떎.
 * \xEC엫\xEC쓽濡\x9C \xEC닔\xEC젙\xEB맂 肄붾뱶\xEC뿉 \xEB\x8C\xED븳 梨낆엫\xEC\x9D \xEC쟾\xEC쟻\xEC쑝濡\x9C \xEC닔\xEC젙\xEC옄\xEC뿉寃\x8C \xEC엳\xEC쓬\xEC쓣 \xEC븣\xEB젮\xEB뱶由쎈땲\xEB떎.
 *
 * @version         5.0
 * @author          ddaemiri
 *
 * @buildno			    5000
 * @date            2007.12.27
 * @note						first release
 *
 * @buildno			    5001
 * @date            2008.01.15
 * @note						\xEC옄泥댁뿉\xEC뒪\xED겕濡\x9C 異붽\xB0, DNS Lookup Timeout 異붽\xB0, DNS Lookup \xEC떎\xED뙣\xEC떆 socket close\xEC븞\xED븯\xEB뒗 遺遺\x84 異붽\xB0
 * @date            2008.01.16
 * @note						Encrypt,Decrypt 紐⑤뱢 媛쒖꽑, pkcs5 padding 異붽\xB0
 * @date            2008.01.24
 * @note						non block connect immediate return check code/str	
 * @date            2008.02.11
 * @note						key load \xED썑 read\xEC뿉\xEB윭諛쒖깮\xEC떆 fclose 異붽\xB0
 * @date            2008.03.03
 * @note						李몄“\xEC뿉 \xEC쓽\xED븳 \xEC쟾\xEB떖(passing by reference) \xEC닔\xEC젙
 * @date            2008.03.11
 * @note						\xEC뿉\xEC뒪\xED겕濡\x9C 留앹랬\xEC냼 Cmd 異붽\xB0
 * @date            2008.03.12
 * @note						湲곗〈 \xEC뿰寃곕맂 IP濡\x9C 留앹랬\xEC냼 \xEC닔\xEC젙
 * @buildno			    5002
 * @note						留앹랬\xEC냼\xEC떆 Sign異붽\xB0(湲곗〈\xEC뿉 \xEC븞\xED뻽\xEC쓬->5001\xEC\x9D 留앹랬\xEC냼\xEC떆 \xEC꽌踰꾩륫\xEC뿉\xEC꽌 \xEC꽌紐낆삤瑜섍\xB0 \xEB궓,洹몃옒\xEB룄 留앹랬\xEC냼泥섎━\xEB뒗 \xEB맖)
 * @date            2008.03.12
 * @buildno			    5016
 * @note						pg1ip, pg2ip 異붽\xB0/痍⑥냼 \xEC썝嫄곕옒\xEC뾾\xEC쓬\xEC떆 drpg濡\x9C \xEC옱\xEC떆\xEB룄
 * @date            2008.04.02
 * @buildno			    5017
 * @note						1)chkfake\xEC떆 \xED뙆\xEB씪誘명꽣 濡쒓퉭 \xEC궘\xEC젣(以묐났)
 * 									2)call-time pass-by-reference => pass-by-value濡\x9C \xEC닔\xEC젙
 * @date            2009.01.12
 * @buildno			    5019
 * @note						delete UIP
 * @date            2009.01.21
 * @note						add mkey/mergelog ( for Makeshop )
 * @date            2009.02.24
 * @note            1)define MKEY deprecated 2009.02.19 ( Makeshop 珥덇린 \xED븳踰덈굹媛\x90. \xEC꽌鍮꾩뒪\xEB릺怨\xA0 \xEC엳\xEB뒗吏\xEB뒗 紐⑤쫫)
 *                  2)Makeshop PG Updrade\xEC슜\xEC쑝濡\x9C \xEC깉濡쒕굹媛\x90 2009.02.19 (interface\xEC뿉\xEC꽌 mkey媛믪쓣 諛쏆븘 泥섎━\xED븯寃\x8C 蹂寃\xBD)
 *                  3)Makeshop PG Updrade\xEC슜\xEC쑝濡\x9C \xEC깉濡쒕굹媛\x90 2009.02.24 (interface\xEC뿉\xEC꽌 mergelog媛믪쓣 諛쏆븘 泥섎━\xED븯寃\x8C 蹂寃\xBD)
 * @date            2009.05.07
 * @note						add BUILDDATE in TXVersion
 * @date            2009.08.05
 * @buildno			    5030
 * @note						add vacct refund
 * @date            2009.12.16
 * @buildno			    5030
 * @note						add recv info
 * @date			2010.07.14  
 * @note 						add Tax, TaxFree info(TX_TAX, TX_TAXFREE)
 * @date 			2010.09.09
 * @note						痍⑥냼\xEC슂泥\xAD\xEC떆 PG \xEC꽕\xEC젙 蹂寃\xBD(\xEB룄硫붿씤->IP, INILib.php)
 * @note 						BUILDDATE update(100414 -> 100909)
 * @note            2011.05.23      5030                XML ELEMENT 以\x91  ROOT 瑜\xBC ROOTINFO濡\x9C \xEC닔\xEC젙
 * @buildno			    5032
 * @note			2012.07.09	嫄곕옒議고쉶 異붽\xB0 (TYPE_INQUIRY)
 * @note			2012.07.09	PHP ini \xED뙆\xEC씪 error display setting 異붽\xB0
 * @buildno			    5036
 * @note			2014.12.09	add gather parameter tid, type
 */
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors', 'Off');

/* GLOBAL */
define("PROGRAM", "INIPHP");
define("LANG", "PHP");
define("VERSION", "5036");
define("BUILDDATE", "141209");
define("TID_LEN", 40);
define("MAX_KEY_LEN", 24);
define("MAX_IV_LEN", 8);

/* TIMEOUT */
define("TIMEOUT_CONNECT", 5);
define("TIMEOUT_WRITE", 2);
define("TIMEOUT_READ", 20);
define("G_TIMEOUT_CONNECT", 2);
define("DNS_LOOKUP_TIMEOUT", 5);

/* LOG LEVEL */
define("CRITICAL", 1);
define("ERROR", 2);
define("NOTICE", 3);
define("INFO", 5);
define("DEBUG", 7);

/* SERVER INFO */
define("PG_HOST", "pg.inicis.com");
define("DRPG_HOST", "drpg.inicis.com");
define("PG_IP", "203.238.37.3");
define("DRPG_IP", "211.219.96.180");
define("PG_PORT", 34049);
define("G_SERVER", "gthr.inicis.com");
define("G_CGI", "/cgi-bin/g.cgi");
define("G_PORT", 80);

define("OK", "0");

define("IV", "Initiative Tech");
define("IMHK", "SFBQSU5JTkZPUk1BVElPTg==");
define("IMHV", "SU5JQ0lTIENJUEhFUi4uLg==");
define("IMJK", "UkVHSVNUX05PX1JDNEtFWQ==");
define("IMJV", "UkVHSVNUX05PX1JDNElW");

//define for mkey
//deprecated 2009.02.19 ( Makeshop 珥덇린 \xED븳踰덈굹媛\x90. \xEC꽌鍮꾩뒪\xEB릺怨\xA0 \xEC엳\xEB뒗吏\xEB뒗 紐⑤쫫)
//Makeshop PG Updrade\xEC슜\xEC쑝濡\x9C \xEC깉濡쒕굹媛\x90 2009.02.19 (interface\xEC뿉\xEC꽌 mkey媛믪쓣 諛쏆븘 泥섎━\xED븯寃\x8C 蹂寃\xBD)
//define("MKEY", 1);
//non block connect immediate return check code/str
define("ERRSTR_INPROGRESS", "Operation now in progress");
define("ERRCODE_INPROGRESS_LINUX", 115);
define("ERRCODE_INPROGRESS_FREEBSD", 36);
define("ERRCODE_INPROGRESS_WIN", 10035);

//------------------------------------------------------
// IFD Header
//------------------------------------------------------
define("MSGHEADER_LEN", 150);
define("BODY_LEN", 5);
define("TAIL_LEN", 5);
define("FLGCRYPTO_LEN", 1);
define("FLGSIGN_LEN", 5);
define("MPUBSN_LEN", 20);
define("PIPGPUBSN_LEN", 20);
define("TXPGPUBSN_LEN", 20);
define("CMD_LEN", 4);
define("MID_LEN", 10);
define("TOTPRICE_LEN", 20);
define("TID_LEN", 40);


//------------------------------------------------------
// IFD CMD
//------------------------------------------------------
define("CMD_REQ_PAY", "0200");
define("CMD_RES_PAY", "0210");
define("CMD_REQ_CAP", "0300");
define("CMD_RES_CAP", "0310");
define("CMD_REQ_CAN", "0420");
define("CMD_RES_CAN", "0430");
define("CMD_REQ_NETC", "0520");
define("CMD_RES_NETC", "0530");
define("CMD_REQ_PRTC", "0620");
define("CMD_RES_PRTC", "0630");
define("CMD_REQ_ACK", "0800");
define("CMD_RES_ACK", "0810");
//\xEC옄泥댁뿉\xEC뒪\xED겕濡\x9C
//added 2008.01.08
define("CMD_REQ_DLV", "3020"); //諛곗넚\xEB벑濡\x9D
define("CMD_REQ_CNF", "3030"); //援щℓ\xED솗\xEC씤
define("CMD_REQ_DNY", "3040"); //援щℓ嫄곗젅 
define("CMD_REQ_DNY_CNF", "3080"); //嫄곗젅\xED솗\xEC씤
define("CMD_REQ_DLV_NETC", "3520"); //諛곗넚\xEB벑濡앸쭩\xEC긽痍⑥냼
define("CMD_REQ_CNF_NETC", "3530"); //援щℓ\xED솗\xEC씤留앹긽痍⑥냼
define("CMD_REQ_DNY_NETC", "3540"); //援щℓ嫄곗젅留앹긽痍⑥냼 
//媛\xEC긽怨꾩쥖\xED솚遺\x88(09.08.05)
define("CMD_REQ_RFD", "0421");
define("CMD_RES_RFD", "0431");

//嫄곕옒議고쉶(12.04.20)
define("CMS_REQ_INQR", "0900");
define("CMS_RES_INQR", "0910");

//\xEC꽌釉뚮ぐ\xED븯\xEC쐞媛留뱀젏\xEB벑濡\x9D(14.03.06)
define("CMS_REQ_OPEN_SUB", "1040");
define("CMS_RES_OPEN_SUB", "1041");

//------------------------------------------------------
// HEADER FLAGS
//------------------------------------------------------
define("FLAG_TEST", "T");
define("FLAG_REAL", "R");
define("FLAG_CRYPTO_NONE", "N");
define("FLAG_CRYPTO_SEED", "S");
define("FLAG_CRYPTO_RC4", "R");
define("FLAG_CRYPTO_3DES", "D");
define("FLAG_SIGN_SHA", "SHA");
define("FLAG_SIGN_SHA1", "SHA1");
define("FLAG_SIGN_MD5", "MD5");

//------------------------------------------------------
//TYPE(\xEC꽌鍮꾩뒪蹂\x84)
//------------------------------------------------------
define("TYPE_SECUREPAY", "securepay");
define("TYPE_CANCEL", "cancel");
define("TYPE_FORMPAY", "formpay");
define("TYPE_RECEIPT", "receipt");
define("TYPE_REPAY", "repay");
define("TYPE_ESCROW", "escrow");  //\xEC옄泥댁뿉\xEC뒪\xED겕濡\x9C!
define("TYPE_CONFIRM", "confirm");
define("TYPE_OCBQUERY", "ocbquery");
define("TYPE_OCBSAVE", "ocbsave");
define("TYPE_OCBPOINT", "OCBPoint");
define("TYPE_AUTH", "auth");
define("TYPE_AUTHBILL", "auth_bill");
define("TYPE_CAPTURE", "capture");
define("TYPE_CMS", "CMS");
define("TYPE_VBANK", "VBank");
define("TYPE_REQREALBILL", "reqrealbill");
define("TYPE_FORMAUTH", "formauth");
define("TYPE_CHKFAKE", "chkfake");
//媛\xEC긽怨꾩쥖\xED솚遺\x88(09.08.05)
define("TYPE_REFUND", "refund");
//媛\xEC긽怨꾩쥖遺遺꾪솚遺\x88(12.06.05)
define("TYPE_VACCTREPAY", "vacctrepay");
//嫄곕옒議고쉶(12.04.20)
define("TYPE_INQUIRY", "inquiry");
//\xEC꽌釉뚮ぐ\xED븯\xEC쐞媛留뱀젏\xEB벑濡\x9D(14.03.06)
define("TYPE_OPENSUB", "opensub");
//------------------------------------------------------
//EscrowType(\xEC옄泥댁뿉\xEC뒪\xED겕濡\x9C \xED\x83\xEC엯)
//added 2008.01.08
//------------------------------------------------------
define("TYPE_ESCROW_DLV", "dlv");
define("TYPE_ESCROW_CNF", "confirm"); //援щℓ\xED솗\xEC씤/嫄곗젅(\xED뵆\xEB윭洹몄씤)
define("TYPE_ESCROW_DNY", "deny");  //\xEC쐞\xEC뿉\xEC꽌 泥섎━\xEB맖,\xEC쓽誘몄뾾\xEC쓬
define("TYPE_ESCROW_DNY_CNF", "dcnf");


//------------------------------------------------------
//PayMethod(\xEC꽌鍮꾩뒪蹂\x84, TX)
//------------------------------------------------------
define("NM_TX_ISP", "VCard");
define("NM_TX_CARD", "Card");
define("NM_TX_HPP", "HPP");
define("NM_TX_ACCT", "DirectBank");
define("NM_TX_VACT", "VBank");
define("NM_TX_OCB", "OCBPoint");
define("NM_TX_CSHR", "CASH");
define("NM_TX_ARSB", "Ars1588Bill");
define("NM_TX_PHNB", "PhoneBill");
define("NM_TX_CULT", "Culture");
define("NM_TX_GAMG", "DGCL");
define("NM_TX_EDUG", "EDCL");
define("NM_TX_TEEN", "TEEN");
define("NM_TX_ESCR", "Escrow");

//------------------------------------------------------
//PayMethod(\xEC꽌鍮꾩뒪蹂\x84, PG)
//------------------------------------------------------
define("NM_ISP", "ISP");
define("NM_CARD", "CARD");
define("NM_HPP", "HPP");
define("NM_ACCT", "ACCT");
define("NM_VACT", "VACT");
define("NM_OCB", "OCB");
define("NM_CSHR", "CASH");
define("NM_ARSB", "ARSB");
define("NM_PHNB", "PHNB");
define("NM_CULT", "CULT");
define("NM_GAMG", "DGCL");
define("NM_EDUG", "EDCL");
define("NM_TEEN", "TEEN");
define("NM_ESCR", "Escrow");

//------------------------------------------------------
//Charset
//------------------------------------------------------
define("EUCKR", "EUC-KR");
define("UTF8", "UTF-8");

//------------------------------------------------------
//URL Encoding/Decoding Name
//------------------------------------------------------
define("URLENCODE", "urlencode");
define("URLDECODE", "urldecode");

//------------------------------------------------------
//\xEC슂泥\xAD\xEC쟾臾\xB8
//------------------------------------------------------
define("TX_GOOSCNT", "GoodsCnt");
define("TX_MOID", "MOID");
define("TX_CURRENCY", "Currency");
define("TX_SMID", "SMID");
define("TX_GOODSCNTS", "GoodsCnts");
define("TX_GOODSNAME", "GoodsName");
define("TX_GOODSPRICE", "GoodsPrice");
define("TX_BUYERNAME", "BuyerName");
define("TX_BUYEREMAIL", "BuyerEmail");
define("TX_BUYERTEL", "BuyerTel");
define("TX_PARENTEMAIL", "ParentEmail");
define("TX_RECVNAME", "RecvName");
define("TX_RECVTEL", "RecvTel");
define("TX_RECVMSG", "RecvMsg");
define("TX_RECVADDR", "RecvAddr");
define("TX_RECVPOSTNUM", "RecvPostNum");
define("TX_TAXFREE", "TaxFree");
define("TX_TAX", "Tax");
//PaymentInfo
define("TX_PAYMETHOD", "PayMethod");
define("TX_JOINCARD", "JoinCard");
define("TX_JOINEXPIRE", "JoinExpire");
define("TX_MAILORDER", "MailOrder");
define("TX_SESSIONKEY", "SessionKey");
define("TX_ENCRYPTED", "Encrypted");
//ReservedInfo
define("TX_MRESERVED1", "MReserved1");
define("TX_MRESERVED2", "MReserved2");
define("TX_MRESERVED3", "MReserved3");
//ManageInfo
define("TX_LANGUAGE", "Language");
define("TX_URL", "URL");
define("TX_TXVERSION", "TXVersion");
define("TX_TXUSERIP", "TXUserIP");
define("TX_TXUSERID", "TXUserID");
define("TX_TXREGNUM", "TXRegNum");
define("TX_ACK", "Ack");
define("TX_RN", "TXRN");
//CancelInfo
define("TX_CANCELTID", "CancelTID");
define("TX_CANCELMSG", "CancelMsg");
define("TX_CANCELREASON", "CancelReason");      //2012-10-19 痍⑥냼\xEC궗\xEC쑀肄붾뱶 異붽\xB0
//媛\xEC긽怨꾩쥖\xED솚遺\x88(09.08.05)
define("TX_REFUNDACCTNUM", "RefundAcctNum");
define("TX_REFUNDBANKCODE", "RefundBankCode");
define("TX_REFUNDACCTNAME", "RefundAcctName");
//PartCancelInfo
define("TX_PRTC_TID", "PRTC_TID");
define("TX_PRTC_PRICE", "PRTC_Price");
define("TX_PRTC_REMAINS", "PRTC_Remains");
define("TX_PRTC_QUOTA", "PRTC_Quota");
define("TX_PRTC_INTEREST", "PRTC_Interest");
define("TX_PRTC_TAX", "Tax");
define("TX_PRTC_TAXFREE", "TaxFree");

define("TX_PRTC_CURRENCY", "Currency");

//援\xAD誘쇱\x9D\xED뻾 I怨꾩쥖\xEC씠泥\xB4 遺遺꾩랬\xEC냼\xEC떆 怨꾩쥖踰덊샇/怨꾩쥖二쇱꽦紐낆텛媛 2011-10-06
define("TX_PRTC_NOACCT", "PRTC_NoAcctFNBC");
define("TX_PRTC_NMACCT", "PRTC_NmAcctFNBC");
//媛\xEC긽怨꾩쥖 遺遺꾪솚遺\x88 愿\xEB젴 異붽\xB0 
define("TX_PRTC_REFUNDFLGREMIT", "PRTC_RefundFlgRemit");
define("TX_PRTC_REFUNDBANKCODE", "PRTC_RefundBankCode");
//CaptureInfo
define("TX_CAPTURETID", "CaptureTID");
//\xED쁽湲덉쁺\xEC닔利\x9D
define("TX_CSHR_APPLPRICE", "CSHR_ApplPrice");
define("TX_CSHR_SUPPLYPRICE", "CSHR_SupplyPrice");
define("TX_CSHR_TAX", "CSHR_Tax");
define("TX_CSHR_SERVICEPRICE", "CSHR_ServicePrice");
define("TX_CSHR_REGNUM", "CSHR_RegNum");
define("TX_CSHR_TYPE", "CSHR_Type");
define("TX_CSHR_COMPANYNUM", "CSHR_CompanyNum");
define("TX_CSHR_OPENMARKET", "CSHR_OpenMarket");
define("TX_CSHR_SUBCNT", "CSHR_SubCnt");
define("TX_CSHR_SUBCOMPANYNAME1", "CSHR_SubCompanyName1");
define("TX_CSHR_SUBCOMPANYNUM1", "CSHR_SubCompanyNum1");
define("TX_CSHR_SUBREGNUM1", "CSHR_SubRegNum1");
define("TX_CSHR_SUBMID1", "CSHR_SubMID1");
define("TX_CSHR_SUBAPPLPRICE1", "CSHR_SubApplPrice1");
define("TX_CSHR_SUBSERVICEPRICE1", "CSHR_SubServicePrice1");
//嫄곕옒議고쉶(12.04.20)
define("TX_INQR_TID", "INQR_TID");
//\xEC꽌釉뚮ぐ\xED븯\xEC쐞媛留뱀젏\xEB벑濡\x9D(14.03.06)
define("TX_OPENREG_TID", "OrgTID");
define("TX_OPENREG_MID", "MID");
define("TX_OPENREG_SUBCNT", "SubCnt");
define("TX_OPENREG_SUBGOODS", "SubGoods");
define("TX_OPENREG_SUBCOMPNO", "SubCompNo");
define("TX_OPENREG_SUBCOMPNM", "SubCompNm");
define("TX_OPENREG_SUBPRSUPPLY", "SubPrSupply");
define("TX_OPENREG_SUBPRFREE", "SubPrFree");
define("TX_OPENREG_SUBPRTAX", "SubPrTax");
define("TX_OPENREG_SUBPRSERVICE", "SubPrService");
define("TX_OPENREG_SUBPRICE", "SubPrice");

//------------------------------------------------------
//
//\xEC쓳\xEB떟\xEC쟾臾\xB8
//
//------------------------------------------------------
//HEAD
define("NM_MID", "MID");
define("NM_TID", "TID");
define("NM_TOTPRICE", "TotPrice");

//BODY
define("NM_GOODSCNT", "GoodsCnt");
define("NM_MOID", "MOID");
define("NM_CURRENCY", "Currency");
define("NM_SMID", "SMID");
define("NM_GOODSNAME", "GoodsName");
define("NM_GOODSPRICE", "GoodsPrice");
define("NM_PAYMETHOD", "PayMethod");
define("NM_RESULTCODE", "ResultCode");
define("NM_RESULTERRORCODE", "ResultErrorCode");
define("NM_RESULTMSG", "ResultMsg");
define("NM_SESSIONKEY", "SessionKey");
define("NM_ENCRYPTED", "Encrypted");
define("NM_CANCELDATE", "CancelDate");
define("NM_CANCELTIME", "CancelTime");
define("NM_EVENTCODE", "EventCode");
define("NM_ORGCURRENCY", "OrgCurrency");
define("NM_ORGPRICE", "OrgPrice");
define("NM_EXCHANGERATE", "ExchangeRate");
define("NM_RESERVEDINFO", "ReservedInfo");
define("NM_MRESERVED1", "MReserved1");
define("NM_MRESERVED2", "MReserved2");
define("NM_MRESERVED3", "MReserved3");
define("PRTC_TID", "PRTC_TID");
define("PRTC_PRICE", "PRTC_Price");
define("PRTC_REMAINS", "PRTC_Remains");
define("PRTC_QUOTA", "PRTC_Quota");
define("PRTC_INTEREST", "PRTC_Interest");
define("PRTC_TYPE", "PRTC_Type");
define("PRTC_CNT", "PRTC_Cnt");
define("NM_CAPTUREDATE", "CaptureDate");
define("NM_CAPTURETIME", "CaptureTime");

define("NM_PGPUBKEY", "PGcertKey");

//RECV DATA XPATH
//XML XPATH
define("ROOTINFO", "INIpay");
define("GOODSINFO", "GoodsInfo");
define("GOODS", "Goods");
define("BUYERINFO", "BuyerInfo");
define("PAYMENTINFO", "PaymentInfo");
define("PAYMENT", "Payment");
define("MANAGEINFO", "ManageInfo");
define("RESERVEDINFO", "ReservedInfo");
//Cancel(NetCancel)
define("CANCELINFO", "CancelInfo");
//PartCancel Encrypt
define("PARTCANCELINFO", "PartCancelInfo");
//Capture
define("CAPTUREINFO", "CaptureInfo");
//嫄곕옒議고쉶(12.04.20)
define("INQUIRYINFO", "InquiryInfo");
//\xEC꽌釉뚮ぐ\xED븯\xEC쐞媛留뱀젏\xEB벑濡\x9D(14.03.06)
define("OPENSUBINFO", "OpenSubInfo");
//Escrow
//added 2008.01.09
define("ESCROWINFO", "EscrowInfo");
define("ESCROW_DELIVERY", "Delivery");
define("ESCROW_CONFIRM", "Confirm");
define("ESCROW_DENY", "Deny");
define("ESCROW_DENYCONFIRM", "DenyConfirm");


//------------------------------------------------------
//Auth Encrypt XPATH
//------------------------------------------------------
//CARD COMMON
define("APPLDATE", "ApplDate");
define("APPLTIME", "ApplTime");
define("APPLNUM", "ApplNum");
//CARD
define("CARD_NUM", "CARD_Num");
define("CARD_EXPIRE", "CARD_Expire");
define("CARD_CODE", "CARD_Code");
define("CARD_APPLPRICE", "CARD_ApplPrice");
define("CARD_BANKCODE", "CARD_BankCode");
define("CARD_QUOTA", "CARD_Quota");
define("CARD_INTEREST", "CARD_Interest");
define("CARD_POINT", "CARD_Point");
define("CARD_AUTHTYPE", "CARD_AuthType");
define("CARD_REGNUM", "CARD_RegNum");
define("CARD_APPLDATE", "CARD_ApplDate");
define("CARD_APPLTIME", "CARD_ApplTime");
define("CARD_APPLNUM", "CARD_ApplNum");
define("CARD_RESULTCODE", "CARD_ResultCode");
define("CARD_RESULTMSG", "CARD_ResultMsg");
define("CARD_TERMINALNUM", "CARD_TerminalNum");
define("CARD_MEMBERNUM", "CARD_MemberNum");
define("CARD_PURCHASECODE", "CARD_PurchaseCode");
//ISP
define("ISP_BANKCODE", "ISP_BankCode");
define("ISP_QUOTA", "ISP_Quota");
define("ISP_INTEREST", "ISP_Interest");
define("ISP_APPLPRICE", "ISP_ApplPrice");
define("ISP_CARDCODE", "ISP_CardCode");
define("ISP_CARDNUM", "ISP_CardNum");
define("ISP_POINT", "ISP_Point");
define("ISP_APPLDATE", "ISP_ApplDate");
define("ISP_APPLTIME", "ISP_ApplTime");
define("ISP_APPLNUM", "ISP_ApplNum");
define("ISP_RESULTCODE", "ISP_ResultCode");
define("ISP_RESULTMSG", "ISP_ResultMsg");
define("ISP_TERMINALNUM", "ISP_TerminalNum");
define("ISP_MEMBERNUM", "ISP_MemberNum");
define("ISP_PURCHASECODE", "ISP_PurchaseCode");
//ACCT
define("ACCT_APPLDATE", "ACCT_ApplDate");
define("ACCT_APPLTIME", "ACCT_ApplTime");
define("ACCT_APPLNUM", "ACCT_ApplNum");
//HPP
define("HPP_APPLDATE", "HPP_ApplDate");
define("HPP_APPLTIME", "HPP_ApplTime");
define("HPP_APPLNUM", "HPP_ApplNum");
//VACT
define("VACT_APPLDATE", "VACT_ApplDate");
define("VACT_APPLTIME", "VACT_ApplTime");
//CASH
define("CSHR_APPLDATE", "CSHR_ApplDate");
define("CSHR_APPLTIME", "CSHR_ApplTime");
define("CSHR_APPLNUM", "CSHR_ApplNum");
//ARSB
define("ARSB_APPLDATE", "ARSB_ApplDate");
define("ARSB_APPLTIME", "ARSB_ApplTime");
define("ARSB_APPLNUM", "ARSB_ApplNum");
//PHNB
define("PHNB_APPLDATE", "PHNB_ApplDate");
define("PHNB_APPLTIME", "PHNB_ApplTime");
define("PHNB_APPLNUM", "PHNB_ApplNum");
//CULT
define("CULT_APPLDATE", "CULT_ApplDate");
define("CULT_APPLTIME", "CULT_ApplTime");
define("CULT_APPLNUM", "CULT_ApplNum");
//DGCL
define("GAMG_CNT", "GAMG_Cnt");
define("GAMG_APPLDATE", "GAMG_ApplDate");
define("GAMG_APPLTIME", "GAMG_ApplTime");
define("GAMG_APPLNUM", "GAMG_ApplNum");

function MakePathGAMG($cnt) {
    for ($i = 1; $i <= $cnt; $i++) {
        define("GAMG_NUM$i", "GAMG_Num$i");
        define("GAMG_REMAINS$i", "GAMG_Remains$i");
        define("GAMG_ERRMSG$i", "GAMG_ErrMsg$i");
    }
}

//EDUG
define("EDUG_APPLDATE", "EDUG_ApplDate");
define("EDUG_APPLTIME", "EDUG_ApplTime");
define("EDUG_APPLNUM", "EDUG_ApplNum");
//TEEN
define("TEEN_APPLDATE", "TEEN_ApplDate");
define("TEEN_APPLTIME", "TEEN_ApplTime");
define("TEEN_APPLNUM", "TEEN_ApplNum");

//----------------------------------
//ERROR CODE
//----------------------------------
//!!\xEC떊TX\xEC뿉 異붽\xB0\xEB맂 \xEC뿉\xEB윭!!!
define("NULL_DIR_ERR", "TX9001");
define("NULL_TYPE_ERR", "TX9002");
define("NULL_NOINTEREST_ERR", "TX9003");
define("NULL_QUOTABASE_ERR", "TX9004");
define("DNS_LOOKUP_ERR", "TX9005");
define("MERCHANT_DB_ERR", "TX9006");
define("DNS_LOOKUP_TIMEOUT_ERR", "TX9007");
define("PGPUB_UPDATE_ERR", "TX9612");

//\xEC븫蹂듯샇\xED솕 \xEC뿉\xEB윭
define("B64DECODE_UPDATE_ERR", "TX9101");
define("B64DECODE_FINAL_ERR", "TX9102");
define("B64DECODE_LENGTH_ERR", "TX9103");
define("GET_KEYPW_EVP_B2K_ERR", "TX9104");
define("GET_KEYPW_FILE_OPEN_ERR", "TX9105");
define("GET_KEYPW_FILE_READ_ERR", "TX9106");
define("GET_KEYPW_DECRYPT_INIT_ERR", "TX9107");
define("GET_KEYPW_DECRYPT_UPDATE_ERR", "TX9108");
define("GET_KEYPW_DECRYPT_FINAL_ERR", "TX9109");
define("ENC_RAND_BYTES_ERR", "TX9110");
define("ENC_INIT_ERR", "TX9111");
define("ENC_UPDATE_ERR", "TX9112");
define("ENC_FINAL_ERR", "TX9113");
define("ENC_RSA_ERR", "TX9114");
define("DEC_RSA_ERR", "TX9115");
define("DEC_CIPHER_ERR", "TX9116");
define("DEC_INIT_ERR", "TX9117");
define("DEC_UPDATE_ERR", "TX9118");
define("DEC_FINAL_ERR", "TX9119");
define("SIGN_FINAL_ERR", "TX9120");
define("SIGN_CHECK_ERR", "TX9121");
define("ENC_NULL_F_ERR", "TX9122");
define("ENC_INIT_RAND_ERR", "TX9123");
define("ENC_PUTENV_ERR", "TX9124");
//\xED븘\xEB뱶泥댄겕
define("NULL_KEYPW_ERR", "TX9201");
define("NULL_MID_ERR", "TX9202");
define("NULL_PGID_ERR", "TX9203");
define("NULL_TID_ERR", "TX9204");
define("NULL_UIP_ERR", "TX9205");
define("NULL_URL_ERR", "TX9206");
define("NULL_PRICE_ERR", "TX9207");
define("NULL_PRICE1_ERR", "TX9208");
define("NULL_PRICE2_ERR", "TX9209");
define("NULL_CARDNUMBER_ERR", "TX9210");
define("NULL_CARDEXPIRE_ERR", "TX9211");
define("NULL_ENCRYPTED_ERR", "TX9212");
define("NULL_CARDQUOTA_ERR", "TX9213");
define("NULL_QUOTAINTEREST_ERR", "TX9214");
define("NULL_AUTHENTIFICATION_ERR", "TX9215");
define("NULL_AUTHFIELD1_ERR", "TX9216");
define("NULL_AUTHFIELD2_ERR", "TX9217");
define("NULL_BANKCODE_ERR", "TX9218");
define("NULL_BANKACCOUNT_ERR", "TX9219");
define("NULL_REGNUMBER_ERR", "TX9220");
define("NULL_OCBCARDNUM_ERR", "TX9221");
define("NULL_OCBPASSWD_ERR", "TX9222");
define("NULL_PASSWD_ERR", "TX9223");
define("NULL_CURRENCY_ERR", "TX9224");
define("NULL_PAYMETHOD_ERR", "TX9225");
define("NULL_GOODNAME_ERR", "TX9226");
define("NULL_BUYERNAME_ERR", "TX9227");
define("NULL_BUYERTEL_ERR", "TX9228");
define("NULL_BUYEREMAIL_ERR", "TX9229");
define("NULL_SESSIONKEY_ERR", "TX9230");
//pg怨듦컻\xED궎 濡쒕뱶 \xEC삤瑜\x98
define("NULL_PGCERT_FP_ERR", "TX9231");
define("NULL_X509_ERR", "TX9232");
define("NULL_PGCERT_ERR", "TX9233");

define("RESULT_MSG_FORMAT_ERR", "TX9234");

// 媛\xEC긽 怨꾩쥖 \xEC씠泥\xB4 \xEC삁\xEC빟
define("NULL_PERNO_ERR", "TX9235");  // 二쇰\xAF쇰쾲\xED샇 鍮좎쭚
define("NULL_OID_ERR", "TX9236");  // 二쇰Ц踰덊샇 鍮좎쭚
define("NULL_VCDBANK_ERR", "TX9237");  // \xEC\x9D\xED뻾肄붾뱶 鍮좎쭚
define("NULL_DTINPUT_ERR", "TX9238");  // \xEC엯湲\x88 \xEC삁\xEC젙\xEC씪 鍮좎쭚
define("NULL_NMINPUT_ERR", "TX9239");  // \xEC넚湲덉옄 \xEC꽦紐\x85 鍮좎쭚
//\xEC떎\xEC떆媛\x84 鍮뚮쭅
define("NULL_BILLKEY_ERR", "TX9240");  // 鍮뚰궎 鍮좎쭚
define("NULL_CARDPASS_ERR", "TX9241");  // 移대뱶 鍮꾨쾲 鍮좎쭚
define("NULL_BILLTYPE_ERR", "TX9242");  // 鍮뚰\x83\xEC엯 \xEB늻\xEB씫
// CMS 怨꾩쥖\xEC씠泥\xB4
define("NULL_PRICE_ORG_ERR", "TX9250"); // CMS 異쒓툑珥앷툑\xEC븸 鍮좎쭚
define("NULL_CMSDAY_ERR", "TX9251"); // CMS 異쒓툑\xEC씪\xEC옄 鍮좎쭚
define("NULL_CMSDATEFROM_ERR", "TX9252"); // CMS 異쒓툑\xEC떆\xEC옉\xEC썡 鍮좎쭚
define("NULL_CMSDATETO_ERR", "TX9253"); // CMS 異쒓툑醫낅즺\xEC썡 鍮좎쭚
// 遺遺꾩랬\xEC냼
define("NULL_CONFIRM_PRICE_ERR", "TX9260"); // \xEC옱\xEC듅\xEC씤 \xEC슂泥\xAD湲덉븸 \xEB늻\xEB씫 \xEC뿉\xEB윭
// \xED쁽湲덉쁺\xEC닔利\x9D 諛쒗뻾
define("NULL_CR_PRICE_ERR", "TX9270"); // \xED쁽湲덇껐\xEC젣 湲덉븸 鍮좎쭚
define("NULL_SUP_PRICE_ERR", "TX9271"); // 怨듦툒媛\xEC븸 鍮좎쭚
define("NULL_TAX_ERR", "TX9272"); // 遺媛\xEC꽭 鍮좎쭚
define("NULL_SRVC_PRICE_ERR", "TX9273"); // 遊됱궗猷\x8C 鍮좎쭚
define("NULL_REG_NUM_ERR", "TX9274");  // 二쇰\xAF쇰쾲\xED샇(\xEC궗\xEC뾽\xEC옄踰덊샇)
define("NULL_USEOPT_ERR", "TX9275"); // \xED쁽湲덉쁺\xEC닔利\x9D \xEC슜\xEB룄 援щ텇\xEC옄 鍮좎쭚

define("PRIVKEY_FILE_OPEN_ERR", "TX9301");
define("INVALID_KEYPASS_ERR", "TX9302");

define("MAKE_TID_ERR", "TX9401");
define("ACK_CHECKSUM_ERR", "TX9402");
define("NETCANCEL_SOCK_CREATE_ERR", "TX9403");
define("NETCANCEL_SOCK_SEND_ERR", "TX9404");
define("NETCANCEL_SOCK_RECV_ERR", "TX9405");
define("LOG_OPEN_ERR", "TX9406");
define("LOG_WRITE_ERR", "TX9407");

define("SOCK_MAKE_EP_ERR", "TX9501");
define("SOCK_CONN_ERR", "TX9502");
define("SOCK_SEND1_ERR", "TX9503");
define("SOCK_SEND2_ERR", "TX9504");
define("SOCK_CLOSED_BY_PEER_ERR", "TX9505");
define("SOCK_RECV1_ERR", "TX9506");
define("SOCK_RECV2_ERR", "TX9507");
define("SOCK_RECV_LEN_ERR", "TX9508");
define("SOCK_TIMEO_ERR", "TX9509");
define("SOCK_ETC1_ERR", "TX9510");
define("SOCK_ETC2_ERR", "TX9511");

define("NULL_ESCROWTYPE_ERR", "TX6000");
define("NULL_ESCROWMSG_ERR", "TX6001");

define("NULL_FIELD_REFUNDACCTNUM", "TX9245");
define("NULL_FIELD_REFUNDBANKCODE", "TX9243");
define("NULL_FIELD_REFUNDACCTNAME", "TX9244");
?>