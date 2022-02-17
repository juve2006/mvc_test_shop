<?php
$customers = $this->get('customer');

foreach($customers as $customer)  :
?>
    <div style="  border: 4px black;margin: 20px;padding: 20px;background: #e8e2e2;width: 500px;">
        <h3> Повне ім'я: <?php echo $customer['first_name'].' '.$customer['last_name']?></h3>
        <a> Місто: <?php echo $customer['city']?></a>
        <p> Телефон: <?php echo $customer['telephone']?></p>
        <p> Електронна адреса: <?php echo $customer['email']?></p>
    </div>
<?php endforeach; ?>


