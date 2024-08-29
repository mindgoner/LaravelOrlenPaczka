# Laravel Orlen Paczka Integration

This package provides integration with the Orlen Paczka API, allowing you to manage receivers, senders, returns, and business packs. Below are examples of how to use the models and requests provided by the package.

# Installation

To install the package, use Composer:

```bash
composer require mindgoner/laravel-orlen-paczka
```

To publish configuration files, type command:
```bash
php artisan vendor:publish --tag=config
```

# Usage
## Sending Parcels

Sending parcels requires configuring OPSender, OPReceiver, OPReturn, OPBusinessPack objects.

### OPReceiver

You can create a new pracel receiver using the `OPReceiver` model:
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;

$OPReceiver = new OPReceiver();
$OPReceiver->EMail = 'email@example.com';
$OPReceiver->FirstName = 'Mind';
$OPReceiver->LastName = 'Goner';
$OPReceiver->CompanyName = 'CompanyName';
$OPReceiver->StreetName = 'Example st.';
$OPReceiver->BuildingNumber = '1';
$OPReceiver->FlatNumber = '';
$OPReceiver->City = 'New York';
$OPReceiver->PostCode = '10069';
$OPReceiver->PhoneNumber = '123123123';
```
Alternatively, you can set the properties by passing dictionary (works with each model):
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;

$OPReceiver = new  OPReceiver(
	'EMail' => 'email@example.com',
	'FirstName' => 'Mind',
	'LastName' => 'Goner',
	'CompanyName' => 'CompanyName',
	'StreetName' => 'Example st.',
	'BuildingNumber' => '1',
	'FlatNumber' => '',
	'City' => 'New York',
	'PostCode' => '10069',
	'PhoneNumber' => '123123123'
);
```

### OPSender
To create a new sender, use the `OPSender` model:

```php
use Mindgoner\LaravelOrlenPaczka\Models\OPSender;

$OPSender = new OPSender();
$OPSender->SenderEMail = 'email@example.com';
$OPSender->SenderFirstName = 'Mind';
$OPSender->SenderLastName = 'Goner';
$OPSender->SenderCompanyName = 'CompanyName';
$OPSender->SenderStreetName = 'Another Example st.';
$OPSender->SenderBuildingNumber= '1';
$OPSender->SenderFlatNumber = '';
$OPSender->SenderCity = 'New York';
$OPSender->SenderPostCode = '10000';
$OPSender->SenderPhoneNumber = '321321321';
$OPSender->SenderOrders = 'order-number'; // Optionally
```

### OPReturn
`OPReturn` model is required to configure where to forward package, if parcel coudn't be delivered to receiver.
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPReturn;

$OPReturn = new OPReturn();
$OPReturn->ReturnAvailable = 0;
$OPReturn->ReturnQuantity = 0;
$OPReturn->ReturnFirstName = 'John';
$OPReturn->ReturnLastName = 'Doe';
$OPReturn->ReturnCompanyName = 'ExampleCorp';
$OPReturn->ReturnStreetName = '123 Example Rd';
$OPReturn->ReturnBuildingNumber= '1A';
$OPReturn->ReturnFlatNumber = '5B';
$OPReturn->ReturnCity = 'ExampleCity';
$OPReturn->ReturnPostCode = '12345';
$OPReturn->ReturnPhoneNumber = '555-1234';
$OPReturn->ReturnPack = 0;
$OPReturn->ReturnDestinationCode = 'BD-105772-DB-12',
```
### OPBusinessPack
To create a new business pack, use the `OPBusinessPack` model:
```php
use Mindgoner\LaravelOrlenPaczka\Models\OPBusinessPack;

$OPBusinessPack = new OPBusinessPack([
	'DestinationCode' => 'BD-105772-DB-12',
	'AlternativeDestinationCode' => 'BD-105772-DB-12',
	'BoxSize' => 'C',
	'PackValue' => 100,
	'CashOnDelivery' => false,
	'AmountCashOnDelivery' => 0,
	'Insurance' => 0,
	'PrintAddress' => '123 Business St.',
	'PrintType' => 'Label',
	'TransferDescription' => 'Business pack for delivery'
]);
```

### Creating package in OrlenPaczka servers:
```php
use Mindgoner\LaravelOrlenPaczka\Requests\GenerateBusinessPack;

$GenerateBusinessPack = new GenerateBusinessPack(
	$OPSender,
	$OPBusinessPack,
	$OPReturn,
	$OPReceiver,
);
$response = $GenerateBusinessPack->send(); // Send method returns OP server's Response
```
Get data from response:
```php
$GenerateBusinessPack->success(); // Returns true if success
$GenerateBusinessPack->getPackCode(); // Returns PackCode
$GenerateBusinessPack->getDestinationCode(); // Returns DestinationCode
$GenerateBusinessPack->getDestinationId(); // Returns DestinationId
$GenerateBusinessPack->getPackPrice(); // Returns PackPrice
$GenerateBusinessPack->getPackPaid(); // Returns PackStatus
```

## Generate Label

```php
use Mindgoner\LaravelOrlenPaczka\Requests\LabelPrintDuplicate;

$LabelPrintDuplicate = new  LabelPrintDuplicate(
	new OPPack(['PackCode' => '2101077997326'])
);
$LabelPrintDuplicate->get();

$LabelPrintDuplicate->base64(); // Returns label in base64 format

// or

$LabelBinary = $LabelPrintDuplicate->pdf(); // Return label in binary format
return response($LabelBinary)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'inline; filename="label.pdf"');

```


## Ordering a pickup
To order a pickup, use the `CallPickup` request:
```php
use Mindgoner\LaravelOrlenPaczka\Requests\CallPickup;

$CallPickup = new CallPickup([
    'packList' => [
        new OPPack(['PackCode' => '2101077997326'])
    ],
    //'readyDate' => date('Y-m-d\T9:00:00', strtotime('+1 day')), // Alternatively (must be in the future)
    //'pickupDate' => date('Y-m-d\T17:00:00', strtotime('+1 day')), // Alternatively (must be in the future)
]);
$CallPickup->send();
```


## Setting up database with destination points and autoupdater

If you'd like to store destination points at your server, feel free to use following code.

### Migration

Use following code to publish migration files:
```bash
php artisan vendor:publish --tag=migrations
```
Migrate file to database:
```bash
php artisan migrate
```
Publish command:
```bash
php artisan vendor:publish --tag=commands
```
Setup scheduled command executing in `app/Console/Kernel.php`:
```php
use Mindgoner\LaravelOrlenPaczka\App\Console\Commands\OPUpdateLocationsList;

$schedule->command('op:update-locations')->dailyAt('05:00');
```