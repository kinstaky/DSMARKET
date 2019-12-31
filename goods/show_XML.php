<?php
	require "../database/connect_db.php";
	if (isset($_GET["keyword"])) $keyword = $_GET["keyword"];
	if (empty($keyword)) $retval = db_select("goods.name AS gname, gid, description, type, price, customer.name AS sname", "goods, customer", "goods.status=0 AND goods.sid=customer.uid AND (TIMESTAMPDIFF(YEAR, goods.time, NOW()) < 5)");
	else $retval = db_select("goods.name AS gname, gid, description, type, price, customer.name AS sname", "goods, customer", "goods.status=0 AND type LIKE '%$keyword%' AND customer.uid=goods.sid AND (TIMESTAMPDIFF(YEAR, goods.time, NOW()) < 5)");
	$xml = "";
	$xml = sprintf("%s<?xml version='1.0' encoding='UTF-8'?>\n", $xml);

	$xml = sprintf("%s<!DOCTYPE Goods[\n", $xml);
	$xml = sprintf("%s<!ELEMENT Goods (Good+)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Good (GoodID, Info)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Info (BasicInfo, Comments)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT BasicInfo (Name, Description, Label, Price, SellerName)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Comments (Comment+)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Comment (BuyerName, Stars, Content)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT GoodID (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Name (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Description (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Label (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Price (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT SellerName (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT BuyerName (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Stars (#PCDATA)>\n", $xml);
	$xml = sprintf("%s<!ELEMENT Content (#PCDATA)> ]>\n", $xml);

	$xml = sprintf("%s<XML>\n", $xml);
	$xml = sprintf("%s    <Goods>\n", $xml);

	/* echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
	echo "<XML>\n";
	echo "    <Goods>\n";*/
	if ($retval->num_rows > 0) {
		while ($row = $retval->fetch_assoc()) {
			$gid = $row["gid"];
			$xml = sprintf("%s        <Good>\n", $xml);
			$xml = sprintf("%s            <GoodID>%s</GoodID>\n", $xml, $row["gid"]);
			$xml = sprintf("%s            <Info>\n", $xml);
			$xml = sprintf("%s                <BasicInfo>\n", $xml);
			$xml = sprintf("%s                    <Name>%s</Name>\n", $xml, $row["gname"]);
			$xml = sprintf("%s                    <Description>%s</Description>\n", $xml, $row["description"]);
			$xml = sprintf("%s                    <Label>%s</Label>\n", $xml, $row["type"]);
			$xml = sprintf("%s                    <Price>%s</Price>\n", $xml, $row["price"]);
			$xml = sprintf("%s                    <SellerName>%s</SellerName>\n", $xml, $row["sname"]);
			$xml = sprintf("%s                </BasicInfo>\n", $xml);
			$xml = sprintf("%s                <Comments>\n", $xml);
			// echo "        <Good>\n";
			// echo "            <GoodID>".$row["gid"]."</GoodID>\n";
			// echo "            <Info>\n";
			// echo "                <BasicInfo>\n";
			// echo "                    <Name>".$row["gname"]."</Name>\n";
			// echo "                    <Description>".$row["description"]."</Description>\n";
			// echo "                    <Label>".$row["type"]."</Label>\n";
			// echo "                    <Price>".$row["price"]."</Price>\n";
			// echo "                    <SellerName>".$row["sname"]."</SellerName>\n";
			// echo "                </BasicInfo>\n";
			// echo "                <Comments>\n";
			$cret = db_select("name, comment, stars", "comments, customer", "customer.uid=comments.uid AND comments.gid=$gid");
			if ($cret->num_rows > 0) {
				while ($crow = $cret->fetch_assoc()) {
					$xml = sprintf("%s                    <Comment>\n", $xml);
					$xml = sprintf("%s                        <BuyerName>%s</BuyerName>\n", $xml, $crow["name"]);
					$xml = sprintf("%s                        <Stars>%s</Stars>\n", $xml, $crow["stars"]);
					$xml = sprintf("%s                        <Content>%s</Content>\n", $xml, $corw["comment"]);
					$xml = sprintf("%s                    </Comment>\n", $xml);
					// echo "                    <Comment>\n";
					// echo "                        <BuyerName>".$crow["name"]."</BuyerName>\n";
					// echo "                        <Stars>".$crow["stars"]."</Stars>\n";
					// echo "                        <Content>".$crow["comment"]."</Content>\n";
					// echo "                    </Comment>\n";
				}
			}
			$xml = sprintf("%s                </Comments>\n", $xml);
			$xml = sprintf("%s            </Info>\n", $xml);
			$xml = sprintf("%s        </Good>\n", $xml);
			// echo "                </Comments>\n";
			// echo "            </Info>\n";
			// echo "        </Good>\n";
		}
	}
	$xml = sprintf("%s    </Goods>\n", $xml);
	$xml = sprintf("%s</XML>\n", $xml);


// 	echo "    </Goods>\n";
// 	echo "</XML>\n";
// 	echo <<<EOF
// <!DOCTYPE Goods[
// <!ELEMENT Goods(Good+)>
// <!ELEMENT Good(GoodID, Info)>
// <!ELEMENT Info(BasicInfo, Comments)>
// <!ELEMENT BasicInfo(Name, Description, Label, Price, SellerName)>
// <!ELEMENT Comments(Comment+)>
// <!ELEMENT Comment(BuyerName, Stars, Content)>
// <!ELEMENT GoodID(#PCDATA)>
// <!ELEMENT Name(#PCDATA)>
// <!ELEMENT Description(#PCDATA)>
// <!ELEMENT Label(#PCDATA)>
// <!ELEMENT Price(#PCDATA)>
// <!ELEMENT SellerName(#PCDATA)>
// <!ELEMENT BuyerName(#PCDATA)>
// <!ELEMENT Stars(#PCDATA)>
// <!ELEMENT Content(#PCDATA)> ]>
// EOF;
	$doc_root = $_SERVER["DOCUMENT_ROOT"];
	$file = fopen("$doc_root/goods/show.xml","w");
	//echo $xml;
	fwrite($file, $xml);
	fclose($file);
	header("Location:show.xml");
?>