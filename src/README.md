// Receiver:

use Mindgoner\LaravelOrlenPaczka\Models\OPReceiver;

$OPReceiver = new OPReceiver(
    'EMail'             => 'email@example.com',
    'FirstName'         => 'Mind',
    'LastName'          => 'Goner',
    'CompanyName'       => 'CompanyName',
    'StreetName'        => 'Example st.',
    'BuildingNumber'    => '1',
    'FlatNumber'        => '',
    'City'              => 'New York',
    'PostCode'          => '10069',
    'PhoneNumber'       => '123123123'
);

Alternatively:

$OPReceiver = new OPReceiver();
$OPReceiver->EMail          = 'email@example.com';
$OPReceiver->FirstName      = 'Mind';
$OPReceiver->LastName       = 'Goner';
$OPReceiver->CompanyName    = 'CompanyName';
$OPReceiver->StreetName     = 'Example st.';
$OPReceiver->BuildingNumber = '1';
$OPReceiver->FlatNumber     = '';
$OPReceiver->City           = 'New York';
$OPReceiver->PostCode       = '10069';
$OPReceiver->PhoneNumber    = '123123123';


// Sender:

use Mindgoner\LaravelOrlenPaczka\Models\OPSender;

$OPSender = new OPSender([
    'SenderEMail'         => 'email@example.com',
    'SenderFirstName'     => 'Mind',
    'SenderLastName'      => 'Goner',
    'SenderCompanyName'   => 'CompanyName',
    'SenderStreetName'    => 'Another Example st.',
    'SenderBuildingNumber'=> '1',
    'SenderFlatNumber'    => '',
    'SenderCity'          => 'New York',
    'SenderPostCode'      => '10000',
    'SenderPhoneNumber'   => '321321321',
    'SenderOrders'        => 'order-number' // Optionally
]);

Alternatively:

$OPSender = new OPSender();
$OPSender->SenderEMail         = 'email@example.com';
$OPSender->SenderFirstName     = 'Mind';
$OPSender->SenderLastName      = 'Goner';
$OPSender->SenderCompanyName   = 'CompanyName';
$OPSender->SenderStreetName    = 'Another Example st.';
$OPSender->SenderBuildingNumber= '1';
$OPSender->SenderFlatNumber    = '';
$OPSender->SenderCity          = 'New York';
$OPSender->SenderPostCode      = '10000';
$OPSender->SenderPhoneNumber   = '321321321';
$OPSender->SenderOrders        = 'order-number'; // Optionally


// Return:

use Mindgoner\LaravelOrlenPaczka\Models\OPReturn;

$OPReturn = new OPReturn([
    'ReturnEMail'         => 'return@example.com',
    'ReturnFirstName'     => 'John',
    'ReturnLastName'      => 'Doe',
    'ReturnCompanyName'   => 'ExampleCorp',
    'ReturnStreetName'    => '123 Example Rd',
    'ReturnBuildingNumber'=> '1A',
    'ReturnFlatNumber'    => '5B',
    'ReturnCity'          => 'ExampleCity',
    'ReturnPostCode'      => '12345',
    'ReturnPhoneNumber'   => '555-1234',
    'ReturnPack'          => 'PACK-1234'
]);


 Alternatively:

 $OPReturn = new OPReturn();
$OPReturn->ReturnEMail         = 'return@example.com';
$OPReturn->ReturnFirstName     = 'John';
$OPReturn->ReturnLastName      = 'Doe';
$OPReturn->ReturnCompanyName   = 'ExampleCorp';
$OPReturn->ReturnStreetName    = '123 Example Rd';
$OPReturn->ReturnBuildingNumber= '1A';
$OPReturn->ReturnFlatNumber    = '5B';
$OPReturn->ReturnCity          = 'ExampleCity';
$OPReturn->ReturnPostCode      = '12345';
$OPReturn->ReturnPhoneNumber   = '555-1234';
$OPReturn->ReturnPack          = 'PACK-1234';



// BusunessPack:

use Mindgoner\LaravelOrlenPaczka\Models\OPBusinessPack;

$OPBusinessPack = new OPBusinessPack([
    'DestinationCode' => 'DEST123',
    'AlternativeDestinationCode' => 'ALT456',
    'ReturnDestinationCode' => 'RET789',
    'BoxSize' => 'Medium',
    'PackValue' => 100.50,
    'CashOnDelivery' => true,
    'AmountCashOnDelivery' => 50.00,
    'Insurance' => true,
    'PrintAddress' => '123 Business St.',
    'PrintType' => 'Label',
    'TransferDescription' => 'Business pack for delivery'
]);

Alternatively:

$OPBusinessPack = new OPBusinessPack();
$OPBusinessPack->DestinationCode          = 'DEST123';
$OPBusinessPack->AlternativeDestinationCode = 'ALT456';
$OPBusinessPack->ReturnDestinationCode    = 'RET789';
$OPBusinessPack->BoxSize                  = 'Medium';
$OPBusinessPack->PackValue                = 100.50;
$OPBusinessPack->CashOnDelivery           = true;
$OPBusinessPack->AmountCashOnDelivery     = 50.00;
$OPBusinessPack->Insurance                = true;
$OPBusinessPack->PrintAddress             = '123 Business St.';
$OPBusinessPack->PrintType                = 'Label';
$OPBusinessPack->TransferDescription      = 'Business pack for delivery';



// Request examples:


// GenerateBusinessPack:

use Mindgoner\LaravelOrlenPaczka\Requests\GenerateBusinessPack;

$GenerateBusinessPack = new GenerateBusinessPack(
    $OPSender,
    $OPBusinessPack,
    $OPReturn,
    $OPReceiver,
);

dd($GenerateBusinessPack->send()); // Return Response



 // Ordering a pickup:
$CallPickup = new CallPickup([
    'packList' => [
        new OPPack(['PackCode' => '2101072764703'])
    ],
    //'readyDate' => date('Y-m-d\TH:i:s', time()), // Alternatively (must be in the future)
    //'pickupDate' => date('Y-m-d\TH:i:s', strtotime('+7 days')), // Alternatively (must be in the future)
]);
$CallPickup->send();