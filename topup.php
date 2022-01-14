<?php
// Object oriented
class topup {
    // Properties (OOP) or Variables (Procedural)
    private $fruits = array(
        'apple' => 15,
        'banana' => 10,
        'orange' => 20,
        'melon' => 25,
        'grape' => 200
    );
    private $balance;

    // Methods (OOP) or Functions (Procedural)
    function __construct($initial) {
        $this->balance = $initial - (($initial*0.03));
    }

    function welcomeMessage() {
        return '<p>Thank you for registering, your current balance is: ' . $this->balance . '</p>';
    }

    function currentBalance() {
        return '<p>Your current balance is: ' . $this->balance . '</p>';
    }

    function buy($item) {
        $fruit = $this->fruits[$item];
        if(($this->balance - $fruit) < 0) {
            return '<p>You have insufficient balance</p>';
        } else {
            $this->balance = ($this->balance - $fruit);
            return '<p>You purchased ' . ucwords($item) . ', current balance: ' . $this->balance . '</p>';
        }  
    }

    function renew($amount) {
        $this->balance = $this->balance + $amount;
        return '<p>Renew is successful, ' . $amount . ' is added to your balance.</p>' . $this->currentBalance();
    }
}