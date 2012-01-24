<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class ExtensionUnavailableException extends Exception {}

class SmartyTemplateNotFoundException extends SmartyException{}

class ArgumentException extends Exception{}

class SaveFailedException extends Exception{}

class LoginFailedException extends Exception{}

class CreateUserException extends Exception{}