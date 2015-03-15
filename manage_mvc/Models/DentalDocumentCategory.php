<?php namespace Ds3\Legacy; ?><?php

namespace Models;

	class DentalDocumentCategory extends Db
	{
		public function getAll()
		{
			$query_string = "SELECT * FROM dental_document_category WHERE status=1 ORDER BY name ASC";
			$query = $this->queryPDO($query_string);
	        $result = $query->fetchAll();
	        return $result;
		}
	}
?>
