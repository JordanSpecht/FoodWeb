<?php

	if( !class_exists('Utility') ) {
		include('../class/Utility.php');
		$Utility = new Utility;
	}
	
	$dbCon = $Utility->genericGetPDO();
	echo '<pre>';
	
	$query = $dbCon->prepare("CREATE DATABASE foodweb;");
	if(!$query->execute())
		var_dump($query->errorInfo());
		
	
	$dbCon = $Utility->getPDO();
	
	$query = $dbCon->prepare("CREATE TABLE users
							  (
								id integer auto_increment not null primary key
								, name varchar(500)
								, email varchar(500) unique
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
		
		
	
	$query = $dbCon->prepare("CREATE TABLE user_passwords
							  (
								id integer auto_increment not null primary key
								, user_id integer
								, password varchar(255)
								, Foreign Key (user_id) references users(id)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
		
	
	$query = $dbCon->prepare("CREATE TABLE vendors
							  (
								id integer auto_increment not null primary key
								, owner_id integer
								, name varchar(500)
								, Foreign Key (owner_id) references users(id)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
	
	$query = $dbCon->prepare("CREATE TABLE menus
							  (
								id integer auto_increment not null primary key
								, vendor_id integer
								, name varchar(500)
								, Foreign Key (vendor_id) references vendors(id)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
	
	$query = $dbCon->prepare("CREATE TABLE menu_photos
							  (
								id integer auto_increment not null primary key
								, menu_id integer
								, caption varchar(500)
								, photo_name varchar(500)
								, Foreign Key (menu_id) references menus(id)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
	
	$query = $dbCon->prepare("CREATE TABLE menu_categories
							  (
								id integer auto_increment not null primary key
								, name varchar(500)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
	
	$query = $dbCon->prepare("CREATE TABLE menu_items
							  (
								id integer auto_increment not null primary key
								, name varchar(500)
								, price decimal(8,2)
								, description varchar(5000)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
			
	$query = $dbCon->prepare("CREATE TABLE menu_category_tree
							  (
								id integer auto_increment not null primary key
								, menu_id integer
								, item_id integer
								, category_id integer
								, left_pointer integer
								, right_pointer integer
								, Foreign Key (menu_id) references menus(id)
								, Foreign Key (item_id) references menu_items(id)
								, Foreign Key (category_id) references menu_categories(id)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
		
	$query = $dbCon->prepare("CREATE TABLE vendor_hours
							  (
								id integer auto_increment not null primary key
								, vendor_id integer
								, day_of_week tinyint
								, opening_time time
								, closing_time time
								, Foreign Key (vendor_id) references vendors(id)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
	
	$query = $dbCon->prepare("CREATE TABLE user_settings
							  (
								id integer auto_increment not null primary key
								, user_id integer
								, visible_name varchar(500)
								, address_line_one varchar(500)
								, city varchar(500)
								, state varchar(500)
								, Foreign Key (user_id) references users(id)
							  )");
	if(!$query->execute())
		var_dump($query->errorInfo());
	
		
	echo '</pre>';
		
	echo '<hr />Done!';

?>