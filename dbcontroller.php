<?php
class DBController
{
    public $mConnector;
    function __construct($conn)
    {
        $this->mConnector = $conn;
    }
    public function getAllTCars()
    {
        $sql = "select * from t_car_base";
        $statement = $this->mConnector->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public function getMCommonByTypeAndCode($type, $code)
    {
        $sql = "SELECT value1 FROM m_common WHERE m_common.data_type=:t and m_common.data_cd=:c";
        $statement = $this->mConnector->prepare($sql);
        $statement->bindValue(":t", $type);
        $statement->bindValue(":c", $code);
        $statement->execute();
        $result = $statement->fetchAll();
        if(empty($result)) return '';
        return $result[0]['value1'];
    }

    public function searchTCars ($keyword, $carNumber){
        $sql="SELECT * from t_car_base where ";
        if($keyword) {
            $sql.= "(maker_name like :mname or car_name like :cname) ";
        }
        if($carNumber) {
            if($keyword) {
                $sql.= "and ";
            }
            $sql.= "frame_number like :fnumber ";
        }
        $statement = $this->mConnector->prepare($sql);
        if($keyword) {
            $keyParam = '%'.$keyword.'%';
			$statement->bindParam(":mname", $keyParam);
			$statement->bindParam(":cname", $keyParam);
        }
        if($carNumber) {
            $carNumParam = '%'.$carNumber.'%';
            $statement->bindParam(":fnumber", $carNumParam);
        }
        $statement->execute();
        $result = $statement->fetchAll();
		return $result;
	}
}
