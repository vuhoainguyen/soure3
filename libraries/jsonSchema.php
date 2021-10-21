<?php 
/**
 * Application Main Page That Will Serve All Requests
 * @package PRO CODE BMWEB FRAMEWORK
 * @author  AP CAO
 * @version 1.0.0
 * @license https://bmweb.vn
 * @PHP >=5.6
 */
class jsonSchema {
	private $d;
	public function __construct($d,$func)
    {  
    	$this->d = $d;
    	$this->func = $func;
    }

    public function ItemList($data){
		global $config,$config_base,$lang;
		if(count($data)>5){
			$dem = 5;
		} else {
			$dem = count($data);
		}
		$result ='';
		for($i=0;$i<$dem;$i++){
		    $result .= '{
		      "@type":"ListItem",
		      "position":'.($i+1).',
		      "url":"'.$config_base.$data[$i]['alias'].'"
		    },';
		}
		$result = substr($result, 0, -1);
		$html = '<script type="application/ld+json">
		{
		  	"@context":"http://schema.org",
		  	"@type":"ItemList",
		  	"itemListElement":[
		  		'.$result.'
			]
		}
		</script>';
		return self::compress($html);
	}
	public function BreadcrumbList($title,$data=array()){
		global $config,$row_favicon,$row_setting,$config_base,$lang,$func;
		$result = '';
		$k = 1;
		$result .= '{
			        "@type": "ListItem",
			        "position": '.$k.',
			        "name": "'.$title.'",
			        "item": "'.$config_base.'"
			      },';
		foreach ($data as $k1 => $v1) {
			$result .= '{
			        "@type": "ListItem",
			        "position": '.($k+1).',
			        "name": "'.$v1['name'].'",
			        "item": "'.$config_base.$v1['alias'].'"
			      },';
			$k++;
		}
		$result = substr($result, 0, -1);
		$html = '<script type="application/ld+json">
			    {
			      "@context": "https://schema.org",
			      "@type": "BreadcrumbList",
			      "itemListElement": [
					'.$result.'
			      ]
			    }
		</script>';

		return self::compress($html);
	}
	public function Library(){
		global $config,$row_favicon,$row_setting,$config_base,$lang,$func;
		$map = explode(',',$row_setting['map_marker']);
		$html = '<script type="application/ld+json">{	
			"@context": "http://schema.org/",
		  	"@type": "Library",
			"url": "'.$config_base.'",
			"name": "'.$row_setting['description'].'",
			"image": "'.$config_base._upload_photo_l.$row_favicon['photo'].'",
			"priceRange": "FREE",
			"hasMap": "'.$row_setting['map_link'].'",	
			"email": "mailto:'.$row_setting['email'].'",
		  	"address": {
		    	"@type": "PostalAddress",
		    	"addressLocality": "'.$row_setting['district'].'",
		    	"addressRegion": "'.$row_setting['city'].'",
		    	"postalCode":"'.$row_setting['postalcode'].'",
		    	"streetAddress": "'.$row_setting['address'].'"
		  	},
		  	"description": "'.$row_setting['description'].'",
		  	"telephone": "+84 '.$row_setting['phone'].'",
		  	"geo": {
		    	"@type": "GeoCoordinates",
		   		"latitude": "'.trim($map[0]).'",
		    	"longitude": "'.trim($map[1]).'"
		 		}, 			
		  	"sameAs" : [ 
			  	"'.$row_setting['fanpage'].'"
		  	]
		}
		</script>';
		return self::compress($html);
	}

	public function SearchAction(){
		global $config,$row_favicon,$row_setting,$config_base,$func;
		$html = '<script type="application/ld+json">
		{
		  "@context": "http://schema.org",
		  "@type": "Website",
		  "url": "'.$config_base.'",
		  "potentialAction": [{
		    "@type": "SearchAction",
		    "target": "'.$config_base.'tim-kiem&keywords={searchbox_target}",
		    "query-input": "required name=searchbox_target"
		  }]
		}
		</script>';
		return self::compress($html);
	}

	public function Person(){
		global $config,$row_setting,$lang,$config_base;
		$html = '<script type="application/ld+json">
		{
		  "@context": "http://schema.org",
		  "@type": "Person",
		  "name": "'.$row_setting['company'].'",
		  "url": "'.$config_base.'",
		  "sameAs": [
		    "'.$row_setting['fanpage'].'"
		  ]
		}
		</script>';
		return self::compress($html);
	}

	public function NewsArticle($data){
		global $config,$lang,$row_setting,$row_favicon,$config_base;
		$html = '<script type="application/ld+json">
		{
		  "@context": "http://schema.org",
		  "@type": "NewsArticle",
		  "mainEntityOfPage": {
		    "@type": "WebPage",
		    "@id": "'.$this->func->getCurrentPageURL().'"
		  },
		  "headline": "'.$data['name'].'",
		  "image": ["'.$config_base._upload_post_l.$data['photo'].'"
		   ],
		  "datePublished": "'.date('c',strtotime($data['createdAt'])).'",
		  "dateModified": "'.date('c',strtotime($data['updatedAt'])).'",
		  "author": {
		    "@type": "Person",
		    "name": "Administrator"
		  },
		  "aggregateRating": {
		    "@type": "AggregateRating",
		    "ratingValue": "5.0",
		    "reviewCount": "'.$data['view'].'"
		  },
		   "publisher": {
		    "@type": "Organization",
		    "name": "'.$row_setting['name'].'",
		    "logo": {
		      "@type": "ImageObject",
		      "url": "'.$config_base._upload_photo_l.$row_favicon['photo'].'"
		    }
		  },
		  "description": "'.$data['description'].'"
		}
		</script>';
		return self::compress($html);
	}

	public function VideoObject($data){
		global $lang,$config_base;
		$result = '';
		foreach ($data as $k => $v) {
			if($v['youtube']!=''){
				$link_y = $v['youtube'];
			}else{
				$link_y = $config_base._upload_video_l.$v['video'];
			}
			$result .= '{
	          "@type": "VideoObject",
	          "position": '.($k+1).',
	          "name": "'.$v['name_'.$lang].'",
	          "url": "'.$config_base.$v['alias_'.$lang].'",
	          "description": "'.$v['desc_'.$lang].'",
	          "thumbnailUrl": [
	            "'.$config_base._upload_photo_l.$v['thumb'].'",
	            "'.$config_base._upload_photo_l.$v['photo'].'"
	          ],
	          "uploadDate": "'.date('c',strtotime($v['createdAt'])).'",
	          "contentUrl": "'.$link_y.'"
	        },';
		}
		$result = substr($result, 0, -1);

		$html = '<script type="application/ld+json">
		{
	      "@context": "https://schema.org",
	      "@type": "ItemList",
	      "itemListElement": [
	        '.$result.'
	      ]
	    }
		</script>';
		return self::compress($html);
	}
		
	public function Review($row_detail,$row_star=1,$num_star=5){
		global $lang,$func,$row_setting,$config,$config_base;
		if(!$num_star){
			$num_star = 5;
		}
		if(!$row_star){
			$row_star = 1;
		}
		$html = '<script type="application/ld+json">
			{
			  "@context": "http://schema.org/",
			  "@type": "Product",
			  "image": "'.$config_base._upload_product_l.$row_detail['photo'].'",
			  "name": "'.$row_detail['name'].'",
			  "review": {
			    "@type": "Review",
			    "reviewRating": {
			      "@type": "Rating",
			      "ratingValue": "'.$num_star.'"
			    },
			    "name": "'.$row_detail['name'].'",
			    "author": {
			      "@type": "Person",
			      "name": "Administrator"
			    },
			    "datePublished": "'.date('c',strtotime($row_detail['createdAt'])).'",
			    "reviewBody": "'.$row_detail['descs'].'",
			    "publisher": {
			      "@type": "Organization",
			      "name": "'.$row_setting['company'].'"
			    }
			  }
			}
			</script>';
		return self::compress($html);
	} 

	public function Product($row_detail,$row_star=1,$num_star=5,$brand,$ratingValue=4,$bestRating=5){
		global $lang,$func,$row_setting,$config,$config_base;
		if(!$num_star){
			$num_star = 5;
		}
		if(!$row_star){
			$row_star = 1;
		}
		$html = '<script type="application/ld+json">{
	      "@context": "https://schema.org/",
	      "@type": "Product",
	      "name": "'.$row_detail['name'].'",
	      "image": [
	        "'.$config_base._upload_product_l.$row_detail['thumb'].'",
		    "'.$config_base._upload_product_l.$row_detail['photo'].'"
	       ],
	      "description": "'.$row_detail['descs'].'",
	      "sku": "'.$row_detail['code'].'",
	      "mpn": "'.$row_detail['code'].'",
	      "brand": {
	        "@type": "Thing",
	        "name": "'.$brand.'"
	      },
	      "review": {
	        "@type": "Review",
	        "reviewRating": {
	          "@type": "Rating",
	          "ratingValue": "'.$ratingValu.'",
	          "bestRating": "'.$bestRating.'"
	        },
	        "author": {
	          "@type": "Person",
	          "name": "'.$row_setting['company'].'"
	        }
	      },
	      "aggregateRating": {
	        "@type": "AggregateRating",
	        "ratingValue": "'.$num_star.'",
		    "reviewCount": "'.$row_star.'"
	      },
	      "offers": {
	        "@type": "Offer",
	        "url": "'.$config_base.$row_detail['alias'].'",
	        "priceCurrency": "VND",
	        "price": "'.$row_detail['price'].'",
	        "priceValidUntil": "'.date('c',strtotime('2030-12-30')).'",
	        "itemCondition": "https://schema.org/UsedCondition",
	        "availability": "https://schema.org/InStock",
	        "seller": {
	          "@type": "Organization",
	          "name": "'.$row_setting['company'].'"
	        }
	      }
	    }</script>';
		return self::compress($html);
	}

	public function Organization(){
		global $config,$row_setting,$row_favicon,$lang,$config_base;
		$html = '
		<script type="application/ld+json">
		{ "@context" : "http://schema.org",
		  "@type" : "Organization",
		  "name":"'.$row_setting['company'].'",
		  "url" : "'.$this->func->getCurrentPageURL().'",
		  "logo":"'.$config_base._upload_photo_l.$row_favicon['photo'].'",
		  "contactPoint" : [
		    {
		      "@type" : "ContactPoint",
		      "telephone" : "+84 '.$row_setting['phone'].'",
		      "contactType" : "Customer Service",
		      "contactOption" : "Support",
		      "areaServed" : ["VN"],
		      "availableLanguage" : ["Viet Nam"]
		    } 
		    ] }
		</script>';
		return self::compress($html);
	}
	static public function compress($buffer){
    	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(': ', ':', $buffer);
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
		return $buffer;
    }

}
?>