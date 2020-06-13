<?php
class ProductImage extends AppModel {
	var $name = 'ProductImage';
	var $validate = array(
		'product_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $actsAs = array(
		'MeioUpload' => array(
			'img_file' => array(
				'dir' => 'img{DS}product images',
				'create_directory' => false,
				'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
				'allowed_ext' => array('.jpg', '.jpeg', '.png'),
				'zoomCrop' => true,
				'thumbsizes' => array(
					'normal' => array('width' => 1080, 'height' => 720),
					'large' => array('width' => 720, 'height' => 480,'maxDimension' => '', 'thumbnailQuality' => 100, 'zoomCrop' => false),
					'small' => array('width' => 187, 'height' => 234,'maxDimension' => '', 'thumbnailQuality' => 100, 'zoomCrop' => false),
					'xsmall' => array('width' => 40, 'height' => 50,'maxDimension' => '', 'thumbnailQuality' => 100, 'zoomCrop' => false),
				),
				'default' => 'default.jpg'
			)
		)
	);
}
