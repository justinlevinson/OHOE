<?php

set_include_path("./zend/library/");

require_once 'Zend/Loader/Autoloader.php'; 
$loader = Zend_Loader_Autoloader::getInstance(); 

$db = new Zend_Db_Adapter_Pdo_Mysql(array(
    'host'     => 'localhost',
    'username' => 'localtalent_ohoe',
    'password' => 'allofthethings',
    'dbname'   => 'localtalent_ohoe'
));

$select = $db->select()
    ->from('categories');
    
$stmt = $select->query();
$result = $stmt->fetchAll();

?>

<html>
	<head>
		<title>one hundred of everything</title>
		<LINK href="style.css" title="compact" rel="stylesheet" type="text/css">
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/lightbox.js"></script>
		<link href="css/lightbox.css" rel="stylesheet" />

	</head>
	<body>
		<div class="container">
		<div class="title"><h1>one hundred of everything</h1></div>
		<?php 
		
			//category iteration
			foreach($result as $category) { ?>
			<div class="category">
				<div class="category-title"><h2><?php echo $category['category_title']; ?></h2></div>
				<div class="category-pictures">
					<?php 
						
						$category_select = $db->select()
							->from('data')
							->where('category = ?', $category['category']);
						$category_stmt = $category_select->query();
						$category_result = $category_stmt->fetchAll();
						
						//get the photos
						
						
						foreach($category_result as $photo) {
							
							if($photo['is_url'] == 1) {
								$photo_message = "<a href=\"".$photo['message']."\">".$photo['message']."</a>";
							} else {
								$photo_message = $photo['message'];
							}
							
							$photo_string = "<div class=\"photo-data\">";
							$photo_string.= "<div class=\"photo-submitter\">Submitted by: ".$photo['submitter']."</div>";
							$photo_string.= "<div class=\"photo-location\">Location: ".$photo['location']."</div>";
							$photo_string.= "<div class=\"photo-location\">Message: ".$photo_message."</div>";
							$photo_string.= "</div>";
							
						?>
							<div class="picture">
								<a rel="lightbox" href="pictures/<?php echo $photo['filename']; ?>" id="<?php echo htmlentities($photo_string); ?>">
								<img src="pictures/<?php echo $photo['filename']; ?>"></a>
							</div>
						<?php
						}
			}
		?>
				</div>
			</div>
	</body>
</html>