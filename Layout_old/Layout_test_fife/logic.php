<?php
    try 
    {
        $pdo = new PDO('mysql:host=localhost;dbname=furniture_factory','root','');
        $sql = "SELECT furniture.check_photo, furniture.deal_number, furniture.composition, furniture.weight, buyer.name AS 'buyer' FROM furniture INNER JOIN buyer ON furniture.id_buyer = buyer.id";
        $one = false;
        $sql1 = "SELECT furniture.composition FROM furniture";
        $selection = $pdo->query($sql1);

        if(!key_exists('clearFilter', $_GET))
        {
            if(count($_GET) > 0)
            {
                $sql .= " WHERE";
                if ($_GET['buyer'] != '')
                {
                    if ($_GET['buyer'])
                    {
                        $sql .= " buyer.name=" . '"' . strip_tags($_GET['buyer']) . '"';
                        $one = true;
                    }
                }
    
                if ($_GET['weight_low'] != '' && $_GET['weight_low'].is_numeric())
                {
                    if ($one)
                    {
                        $sql .= " AND";
                    }
                    $sql .= " furniture.weight>=" . $_GET['weight_low'];
                    $one = true;
                }
    
                if ($_GET['weight_max'] != '' && $_GET['weight_max'].is_numeric())
                {
                    if ($one)
                    {
                        $sql .= " AND";
                    }
                    $sql .= " furniture.weight<=" . $_GET['weight_max'];
                    $one = true;
                }
    
                if ($_GET['deal_number_imput'] != '')
                {
                    if ($one)
                    {
                        $sql .= " AND";
                    }
                    $sql .= " furniture.deal_number LIKE " . '"%'. strip_tags($_GET['deal_number_imput']) . '%"';
                    $one = true;
                }
    
                if ($_GET['composition_imput'] != '')
                {
                    if ($one)
                    {
                        $sql .= " AND";
                    }
                    $sql .= " furniture.composition LIKE " . '"%'. strip_tags($_GET['composition_imput']) . '%"';
                    $one = true;
                }
            }
        }
        $result = $pdo->query($sql);
        $pdo = null;
    }
    catch (PDOExcephion $excephion)
    {
        /*echo $excephion->getMessage();*/
        header('Refresh: 0; url=furniture.php');
    }
?>