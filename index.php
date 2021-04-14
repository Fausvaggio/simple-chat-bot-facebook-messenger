<?php
require './vendor/autoload.php';
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

use BotMan\Drivers\Facebook\Extensions\Element as Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton as ElementButton;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate as ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate as GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\ListTemplate as ListTemplate;
use BotMan\Drivers\Facebook\Extensions\ReceiptTemplate as ReceiptTemplate;
use BotMan\Drivers\Facebook\Extensions\ReceiptElement as ReceiptElement;
use BotMan\Drivers\Facebook\Extensions\ReceiptAddress as ReceiptAddress;
use BotMan\Drivers\Facebook\Extensions\ReceiptSummary as ReceiptSummary;
use BotMan\Drivers\Facebook\Extensions\ReceiptAdjustment as ReceiptAdjustment;

$config = [
    'facebook' => [
        'token' => 'YOUR TOKEN',
        'app_secret' => 'App Secret',
        'verification'=>'Your Verification',
    ],
    'botman' => [
        'conversation_cache_time' => 0,
    ],
];

DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

$botman = BotManFactory::create($config);

$botman->hears('GET_STARTED_BOTPANDAZURE', function (BotMan $bot) {
	$bot->typesAndWaits(1);
    $user = $bot->getUser();       
    $bot->reply('Hola '.$user->getFirstName().' '.$user->getLastName().', soy el Bot virtual, por favor elige una de las siguientes opciones para poder ayudarte... :) :p');
    $bot->reply(ButtonTemplate::create('¿En que puedo ayudarte?')               
        ->addButton(ElementButton::create('Contactos')
            ->type('postback')
            ->payload('Contactos')
        )
    );
});

$botman->hears('Inicio', function (BotMan $bot) {
    $bot->typesAndWaits(1);          
    $bot->reply(ButtonTemplate::create('¿Por favor elige una de las siguientes opciones para poder ayudarte?')               
        ->addButton(ElementButton::create('Contactos')
            ->type('postback')
            ->payload('Contactos')
        )
    );
});

$botman->hears('Contactos', function (BotMan $bot) {
    $bot->typesAndWaits(1);        
    $bot->reply('Nos puede contactar enviando un email a: info@hotmail.com');            
    $bot->reply(ButtonTemplate::create('Enviando un mensaje al WhatsApp: +51 97847547')        
        ->addButton(ElementButton::create('Ir al Inicio')
            ->type('postback')
            ->payload('Inicio')
        )                
    );       
});

$botman->hears('.*hola.*', function ($bot) {
    $user = $bot->getUser();       
    $bot->reply('Hola '.$user->getFirstName().' '.$user->getLastName().', soy el Bot virtual, por favor elige una de las siguientes opciones para poder ayudarte... :) :p');
    $bot->reply(ButtonTemplate::create('¿En que puedo ayudarte?')
        ->addButton(ElementButton::create('Promociones')
            ->type('postback')
            ->payload('Promociones')
        )
        ->addButton(ElementButton::create('Contactos')
            ->type('postback')
            ->payload('Contactos')
        )
    );
});

$botman->fallback(function($bot) {
    $bot->typesAndWaits(1);    
    $bot->reply(ButtonTemplate::create('Lo siento soy un bot, no entiendo su consulta...:( ')        
        ->addButton(ElementButton::create('Ir al Inicio')
            ->type('postback')
            ->payload('Inicio')
        )                
    );
});



$botman->listen();