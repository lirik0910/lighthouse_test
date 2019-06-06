<?php

namespace App\GraphQL\Mutations;

use App\ApprovePhone;
use App\Exceptions\CodeSenderException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BaseCodeResolver
{
    public $phone;
    public $current_object;

    /*
     * Получает запись таблицы ApprovePhone, если указанный телефон когда-либо использовался для регистрации
     */
    public function getOnCheckingPhone()
    {
        return ApprovePhone::where('phone', $this->phone)->first();
    }

    /*
     * Запись в базу нового сгенерированного кода
     */
    public function setOnCheckingPhone()
    {
        $this->current_object = $this->getOnCheckingPhone();

        if(!empty($this->current_object)){
            if($this->retryCodeTimeout()){
                 $this->updatePhoneCheck();

                 return $this->getOnCheckingPhone();
            } else{
                throw new CodeSenderException(
                    'You have already requested the code. Please try again later!',
                    'Operation timeout'
                );
            }
        } else{
            $this->createPhoneCheck();

            return $this->getOnCheckingPhone();
        }
    }

    /*
     * Добавление новой записи в таблицу с зарегистрированными номерами
     */
    public function createPhoneCheck()
    {
        return ApprovePhone::create([
            'phone' => $this->phone,
            'code' => $this->generateCode(),
            'token' => $this->generateToken(),
        ]);
    }

    /*
     * Обновление записи в таблице зарегистрированных номеров
     */
    public function updatePhoneCheck()
    {
        return $this->current_object->update([
            'code' => $this->generateCode(),
            'token' => $this->generateToken()
        ]);
    }

    /*
     * Генерация кода для отправки по SMS
     */
    public function generateCode()
    {
        return Str::random(6);
    }

    /*
     * Генерация токена для добавления в куки
     */
    public function generateToken()
    {
        return Str::random(60);
    }

    /*
    * Проверяет, прошло ли 3 минуты с последней отправки кода
    */
    public function retryCodeTimeout()
    {
        if($this->current_object->timeFromSend() >= 3){
            return true;
        }

        return false;
    }

    /*
     * Проверяет, устарел ли код у полученной записи
     */
    public function checkIfExpire()
    {
        $this->current_object = $this->getOnCheckingPhone();

        if($this->current_object->timeFromSend() >= 60){
            return true;
        }

        return false;
    }

    /*
     * Проверяет актуален ли токен и совпадает ли с тем, который приходит от клиента
     */
    public function validateToken()
    {
        if(!$this->checkIfExpire()){

            $client_token = Cookie::get('token');

            if($client_token === $this->current_object->token){
                return true;
            }
        }

        return false;
    }

    /*
     * Запись в файл (якобы отправка по SMS) кода
     */
    public function writeToFile(ApprovePhone $checkingPhone)
    {
        $content = now() . ' ' . $checkingPhone->getAttribute('phone') . ' ' . $checkingPhone->getAttribute('code');

        return Storage::append('sending_codes.txt', $content);
    }

    /*
     * Проверяет на совпадение токен, который лежит у клиента с тем, который лежит в базе
     */
    public function checkToken(ApprovePhone $checkingPhone)
    {
        $token = Cookie::get('token');

        if(!empty($token) && $token = $checkingPhone->token){
            return true;
        }

        return false;
    }
}
