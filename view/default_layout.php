<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title><?php echo $this->title?></title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<meta name="author" content="Radosław Kłos"/>
	<meta name="application_name" content="Genesis framework"/>
	<link rel="shortcut icon" href="public/images/favicon.ico" />
	<base href="<?php echo '/' . Genesis\library\main\appConfig::getConfig('siteAdres');?>"/>
<?php foreach ($this->style as $style){?>
	<link rel="stylesheet" type="text/css" href="public/css/<?php echo $style;?>"/>
<?php } foreach ($this->script as $script) echo '\t<script src="public/scripts/' . $script . '"></script>' ;?>	
</head>
	
<body>
<?php $this->render_view();?>

</body>
</html>	