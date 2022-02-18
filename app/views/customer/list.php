<?php
$customers = $this->get('customer');

foreach($customers as $customer)  :
?>
    <div class="customer">
        <h3> Повне ім'я: <?php echo $customer['first_name'].' '.$customer['last_name']?></h3>
        <a> Місто: <?php echo $customer['city']?></a>
        <p> Телефон: <?php echo $customer['telephone']?></p>
        <p> Електронна адреса: <?php echo $customer['email']?></p>
    </div>
<?php endforeach; ?>


