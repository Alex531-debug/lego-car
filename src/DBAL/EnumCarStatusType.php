<?php


namespace App\DBAL;


class EnumCarStatusType extends EnumType
{
    protected $name = "enumcarstatus";

    protected $values = ['available', 'on_order'];

}