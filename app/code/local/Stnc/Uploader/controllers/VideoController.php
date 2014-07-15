<?php
class Stnc_Uploader_VideoController extends Mage_Core_Controller_Front_Action
{


    public function indexAction()
    {
$id= $this->getRequest()->getParam('id');

$resource= Mage::getSingleton('core/resource');
$readConnection = $resource->getConnection('core_read');
			
$sql='SELECT filename FROM stnc_videoupload WHERE status=1 and videoupload_id="'.$id.'"';
 $video= $readConnection->fetchOne($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"><html>
<head>
<title>Aris Pirlanta </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="Ürün İnceleme, küpe, yüzük, kolye, bileklik, gerdanlık, set, elmas, pırlanta, safir, yakut, zümrüt" />
<meta name="keywords" content="küpe, küpeler, yüzük, kolye, bileklik, gerdanlık, set, elmas, pırlanta, safir, yakut, zümrüt, alışveriş, indirim, online, shop, shopping, kuyum, kuyumcu, jewellery" />
<style>
	body {background:#000; margin:0px; padding: 0px;}
</style>
</head>
<body>
<center>
<script language="javascript" type="text/javascript" src="<?php echo Mage::getBaseUrl('js');?>stnc/swfobject1.js"></script>
	<div id="container">Flash Player indirmek için <a href="http://get.adobe.com/flashplayer/">tıklayınız</a>.</div>
<script type="text/javascript">
	var s1 = new SWFObject("<?php echo Mage::getBaseUrl('skin');?>frontend/default/default/player/player.swf","ply","320","270","9","#FFFFFF");
		s1.addParam("allowfullscreen","true");
		s1.addParam("allowscriptaccess","always");
		s1.addParam("flashvars","file=<?php echo Mage::getBaseUrl('media').'stnc/uploader/'.$video;?>&image=<?php echo Mage::getBaseUrl('skin');?>frontend/default/default/images/preview.jpg");
		s1.write("container");
</script>

</center>



</body>
</html>


<?php 
		/*$this->loadLayout();     
		$this->renderLayout();*/
    }
	
	
	
	public function returnajax($array){
		$jsonData = json_encode($array);
		$this->getResponse()->setHeader('Content-type', 'application/json');
		echo $this->getResponse()->setBody($jsonData);
		die();
	}
	
	 public function videoAction()
    {
        $data   = $this->getRequest()->getPost();	
		$data['ratings'];
		
             	$this->returnajax(
						array(
							"RESULT"=>"Error",
							"MESSAGE"=>'Bir sorun oluştu ',
						
							"IMAGE"=>'/skin/frontend/mg/default/images/error.png',
					
						)
					);
 
    }
	
	
	

	

}