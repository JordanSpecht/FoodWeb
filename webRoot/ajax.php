<?php

	if( !array_key_exists('method', $_POST) )
		$_POST['method'] = '';

	switch($_POST['method']) {
		
		
		case 'addMenuCategory': {
			$arrRet = array();
			if( !class_exists('MenuController') ) {
				include(dirname(__FILE__) . '/class/Controller/MenuController.php');
				$MenuController = new MenuController($_POST['menuId']);
			}
			$ret = $MenuController->addMenuCategory($_POST['parentLeftPointer'], $_POST['categoryName']);
			
			$arrRet['returnStatus'] = (($ret) ? 0 : 1);
			$arrRet['returnString'] = '';
			echo json_encode($arrRet);
			break;
		}
		
		case 'getMenu': {
			$arrRet = array();
			if( !class_exists('VendorController') ) {
				include(dirname(__FILE__) . '/class/Controller/VendorController.php');
				$VendorController = new VendorController;
			}
			$arrRet['menus'] = $VendorController->getMenus();
			
			$arrRet['returnStatus'] = 0;
			$arrRet['returnString'] = '';
			echo json_encode($arrRet);
			break;
		}
			
		case 'getMenuItems': {
			$arrRet = array();
			include(dirname(__FILE__) . '/class/Controller/MenuController.php');
			$MenuController = new MenuController($_POST['menu']);;
				
			$arrRet['menuElements'] = $MenuController->getChildren($_POST['element']);
			
			$arrRet['returnStatus'] = 0;
			$arrRet['returnString'] = '';
			echo json_encode($arrRet);
			break;
		}
			
		case 'newMenu': {
			if( !class_exists('VendorController') ) {
				include(dirname(__FILE__) . '/class/Controller/VendorController.php');
				$VendorController = new VendorController;
			}
			$result = $VendorController->addMenu($_POST['menuName']);
			$arrRet = array();
			$arrRet['returnStatus'] = (($result) ? 0 : 1);
			$arrRet['returnString'] = (($result) ? '' : 'Not a Vendor');
			echo json_encode($arrRet);
			break;
		}
		
		default: {
			$arrRet = array();
			$arrRet['returnStatus'] = 1;
			$arrRet['returnString'] = 'Invalid Method Specified';
			echo json_encode($arrRet);
			break;
		}
	}

?>