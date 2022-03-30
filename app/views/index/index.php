<?php
    use Controllers\CustomerController;
    $customer = CustomerController::getCustomer();
    if ($customer) : ?>
<?php echo " " . $customer["first_name"] . " " . $customer["last_name"] . ', hello!';?>
<?php else : ?>
<h3>Hello, unauthorized user!</h3>
    <?php endif ?>

