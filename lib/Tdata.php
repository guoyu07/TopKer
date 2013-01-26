<?php 

class TClient
{
	private static $topClient;
	public static function getTopClient($format = 'json')
	{
		if (null === self::$topClient)
		{
			self::$topClient = new TopClient();
			self::$topClient->appkey = TB_APP_KEY;
			self::$topClient->secretKey = TB_APP_SECRET;
			self::$topClient->format = $format;
		}
		return self::$topClient;
	}
}

class Tdata
{
	public static function getTmallRecommended($catId)
	{
		$items = $track_iid = array();
		if (empty($catId)) return $items;

		$c   = TClient::getTopClient();
		$req = new TmallSelectedItemsSearchRequest;
		
		$req->setCid($catId);
		
		$resp = $c->execute($req);
		$req  = new ItemsListGetRequest();

		$req->setFields("detail_url, num_iid,title,price,pic_url");

		if (isset($resp->item_list) && $resp->item_list) foreach ($resp->item_list as $v)
		{
			if ($v && is_array($v)) foreach ($v as $vv)
			{
				$track_iid[] = $vv->track_iid;
			}
		}
		if (!empty($track_iid))
		{	
			# every request max 20
			$new = array();
			for ($i = 0 , $length = count($track_iid); $i < $length; $i += 20)
			{
				$new[] = array_slice($track_iid, $i, 20);
			}

			foreach ($new as $v)
			{
				$req->setTrackIids(implode(',', $v));
				$resp = $c->execute($req);

				if (isset($resp->items->item))
				{
					$i = $resp->items->item;
					foreach ($i as $vv)
					{
						$items[] = array(
							'detail_url' => $vv->detail_url,
							'title' => $vv->title,
							'image' => $vv->pic_url,
						);
					}
				}
			}
			unset($new, $resp, $req);
		}
		return $items;
	}

	public static function getAllCategory()
	{
		$cats = array();
		$c    = TClient::getTopClient();

		$req  = new ItemcatsGetRequest;
		$req->setFields("cid,parent_cid,name,is_parent");
		$req->setParentCid(0);

		$resp = $c->execute($req);

		if (isset($resp->item_cats) && isset($resp->item_cats->item_cat))
		{
			$item_cat = $resp->item_cats->item_cat;
			
			if ($item_cat && is_array($item_cat)) 
				foreach ($item_cat as $key => $val) {
					$cats[$val->cid] = $val->name;
			}
			unset($item_cat);
		}
		unset($c, $req);

		return $cats;
	}
}