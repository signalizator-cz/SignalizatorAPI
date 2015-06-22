<?php

class Query
{

    private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function find($x1, $y1, $x2, $y2, $limit = 500)
    {
        $sql = "SELECT doc.id, doc.title, doc.source as url, doc.loadedTime as date, 
				loc.id as locid, loc.lat as lat, loc.lon as lng, loc.address
				FROM documents as doc
				JOIN addresses_coordinates as loc ON doc.id = loc.document_id 
				WHERE  loc.lat > :y1 AND loc.lat < :y2 
				AND loc.lon > :x1 AND loc.lon < :x2 
				LIMIT :limit";
        $q = $this->connection->prepare($sql);
        $q->execute([
            'x1' => $x1,
            'y1' => $y1,
            'x2' => $x2,
            'y2' => $y2,
            'limit' => $limit
        ]);
        
        $records = null;
        foreach ($q as $row) {
            if (! isset($records[$row['id']])) {
                $doc['id'] = $row['id'];
                $doc['title'] = $row['title'];
                $doc['url'] = $row['url'];
                $doc['date'] = $row['date'];
                $records[$row['id']] = $doc;
            }
            $mark['id'] = $row['locid'];
            $mark['lat'] = $row['lat'];
            $mark['lng'] = $row['lng'];
            $mark['address'] = $row['address'];
            $records[$row['id']]['markers'][] = $mark;
        }
        
        return $records;
    }
}