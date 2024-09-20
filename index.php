著作权归作者所有。
商业转载请联系作者获得授权，非商业转载请注明出处。
作者：xingqihan
链接：https://www.skaco.cn/archives/921.html
来源：https://www.skaco.cn/

<?php
$apiUrl = 'http://api.suxun.site/api/sixs?type=json';
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
if ($data['code'] === '200') {
	$dbHost = '127.0.0.1';
	$dbUser = '数据库名';
	$dbPass = '数据库密码';
	$dbName = '数据库名';
	$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
	if ($conn->connect_error) {
		die("连接失败: ". $conn->connect_error);
	}
	$categoryName = '你需要的分类名称';
	$sqlGetCategoryId = "SELECT mid FROM `typecho_metas` WHERE `type`='category' AND `name`='$categoryName'";
	$result = $conn->query($sqlGetCategoryId);
	if ($result && $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$categoryId = $row['mid'];
	} else {
		die("无法找到指定分类的 ID。");
	}
	$sqlGetLastCid = "SELECT MAX(CAST(SUBSTRING(cid, 1) AS UNSIGNED)) AS last_cid FROM `typecho_contents`";
	$resultLastCid = $conn->query($sqlGetLastCid);
	$lastCid = 0;
	if ($resultLastCid && $resultLastCid->num_rows > 0) {
		$rowLastCid = $resultLastCid->fetch_assoc();
		$lastCid = $rowLastCid['last_cid']? $rowLastCid['last_cid'] + 1 : 1;
	}
	$date = date('Y 年 n 月 j 日，l');
	$title = $date. '，每日 60 秒读懂世界';
	$content = '<img src="'.$data['head_image'].'"><br>';
	foreach ($data['news'] as $newsItem) {
		$content.= $newsItem.'<br>';
	}
	$content.= '<br>'.$data['weiyu'];
	$tags = '每日 60 秒';
	$cid = $lastCid;
	$slug = date('Ymd');
	$sqlInsertPost = "INSERT INTO `typecho_contents` (`cid`, `title`, `slug`, `created`, `modified`, `text`, `order`, `authorId`, `template`, `type`, `status`, `password`, `commentsNum`, `allowComment`, `allowPing`, `allowFeed`, `parent`, `views`, `agree`) 
			VALUES ('$cid', '$title', '$slug', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), '$content', '0', '1', NULL, 'post', 'publish', NULL, '0', '1', '1', '1', '0', '1', '0')";
	if ($conn->query($sqlInsertPost) === TRUE) {
		$lastInsertId = $conn->insert_id;
		
		$sqlInsertRelation = "INSERT INTO `typecho_relationships` (`cid`, `mid`) VALUES ($lastInsertId, $categoryId)";
		if ($conn->query($sqlInsertRelation) === TRUE) {
			echo "文章发布成功！";
		} else {
			echo "Error inserting relationship: ". $conn->error;
		}
	} else {
		echo "Error inserting post: ". $sqlInsertPost. "<br>". $conn->error;
	}

	$conn->close();
} else {
	echo '获取 API 数据失败。';
}
?> 
