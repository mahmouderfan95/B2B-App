<?php
namespace App\Services\Payments\Urway;

use App\Models\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use URWay\Client as UrwayClient;

class PaymentUrlGenerator extends UrwayClient {
    public function __construct(
        private $transaction
    ) {
        $log = new Logger('HttpLogger');

        $log->pushHandler(
            new StreamHandler(
                storage_path(sprintf('logs/http/%d/%d/%s.log', date('Y'), date('m'), date('Y-m-d')))
            )
        );
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler); // Wrap w/ middleware

        $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            $response->getBody()->rewind();

            return $response;
        }));

        $stack->push(Middleware::log(
            $log,
            new MessageFormatter('{method} {url} {req_body} - {code} - {res_body}')
        ));


        $this->guzzleClient = new Client(['handler' => $stack]);
//        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function __invoke() : mixed {
        $this->setTrackId($this->transaction->id)
            ->setCustomerEmail($this->transaction?->client?->email ?? "{$this->transaction->client_id }@saudidates.sa")
            ->setCustomerIp(request()->ip())
            ->setCurrency('sar')
            ->setCountry($this->transaction->addresses->country->code ?? Constants::country)
            ->setAmount(number_format($this->transaction->total / 100, 2, '.', ''))
            ->setRedirectUrl(route('paymant-callback'))
            ->setAttribute('udf1', $this->transaction->address_id)
            ->setAttribute('udf3', $this->transaction->use_wallet)
            ->setAttribute('udf4', Config::get('app.locale'));

        $this->mergeAttributes(['action' => '1']);

        $response = $this->pay();

        Log::channel("urway")->info(
            "Urway pay request from ourside",
            ['request_data' => $this->attributes, 'response_data' => (array)$response]
        );
        return $response;
    }
}
