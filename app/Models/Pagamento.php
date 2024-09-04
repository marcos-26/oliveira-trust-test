<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Pagamento extends Model
{

    public static function factory(): Pagamento
    {
        return app()->make(Pagamento::class);
    }

    /** @attributes
     * $status
     * $transaction_id
     */

    protected $fillable = [
        'uuid',
        'status',
        'formaPagamento',
        'valorTotal',
        'dataPagamento',
        'status',
    ];


     /**
      * Get the value of status
      */
     public function getStatus()
     {
          return $this->status;
     }

     /**
      * Set the value of status
      *
      * @return  self
      */
     public function setStatus($status)
     {
          $this->status = $status;

          return $this;
     }
}
