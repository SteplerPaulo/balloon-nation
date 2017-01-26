<?php
class Banner extends AppModel {
	var $name = 'Banner';
	
	
	var $actsAs = array(
		'MeioUpload' => array(
			'img_file' => array(
				'dir' => 'img{DS}banner',
				'create_directory' => false,
				'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
				'allowed_ext' => array('.jpg', '.jpeg', '.png'),
				'zoomCrop' => true,
				'thumbsizes' => array(
					'small' => array('width' => 80, 'height' => 80,'maxDimension' => '', 'thumbnailQuality' => 100, 'zoomCrop' => false),
					'medium' => array('width' => 500, 'height' => 230,'maxDimension' => '', 'thumbnailQuality' => 100, 'zoomCrop' => false),
					'large' => array('width' => 950, 'height' => 350,'maxDimension' => '', 'thumbnailQuality' => 100, 'zoomCrop' => false),
				),
				'default' => 'default.jpg'
			)
		)
	);
}
