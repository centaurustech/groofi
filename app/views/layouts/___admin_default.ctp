<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
			<title>Outsider admin</title>
		<?
            echo $this->Html->css('/css/admin_default');
            echo $this->Html->script( 'jquery/main' ,array('once'=>true,'inline'=>true));
            echo $this->Html->script( 'jquery/ui' ,array('once'=>true,'inline'=>true));
            echo $this->Html->script( 'jquery/superfish' ,array('once'=>true,'inline'=>true));
            echo $this->Html->script( 'jquery/uploadify' ,array('once'=>true,'inline'=>true));
            echo $this->Html->script( 'swfobject' ,array('once'=>true,'inline'=>true));

		?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	</head>
	<body>
		<div id="header">
			<img src="/img/static/assets/logo_admin.png" alt="outsider" class="siteLogo" />
			<?
                if ($authUser){
                    echo $modules->adminMenu($menu);
                }
            ?>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){ $("ul#admin_menu").superfish(); });
		</script>

		<div id="divCenter">
			 <div id="content" class="content <?=$this->params['controller'] ?> <?=$this->params['action'] ?>">
                 <div class="padding">
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $content_for_layout ?>
                </div>
			 </div>
		</div>
		<div id="footer">&nbsp;</div>
	</body>
</html>
