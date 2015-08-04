<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title><?php echo $this->title?></title>
	<base href="/"/>
<?php foreach ($this->style as $style)?>
	<link rel="stylesheet" type="text/css" href="public/css/<?php echo $style;?>"/>
<?php foreach ($this->script as $script) echo '\t<script src="public/scripts/' . $script . '"></script>' ;?>	
</head>
	
<body>
	<?php include $this->get_content();?>
</body>
</html>	