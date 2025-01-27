<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class File extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['value'];

    public static function factory(): self
    {
        return app()->make(self::class);
    }

    public function rptDt()
    {
        return $this->embedsOne(RptDt::class);
    }

    public function tckrSymb()
    {
        return $this->embedsOne(TckrSymb::class);
    }
    public function mktNm()
    {
        return $this->embedsOne(MktNm::class);
    }
    public function sctyCtgyNm()
    {
        return $this->embedsOne(SctyCtgyNm::class);
    }
    public function isin()
    {
        return $this->embedsOne(ISIN::class);
    }

    public function crpnNm()
    {
        return $this->embedsOne(CrpnNm::class);
    }



    /**
     * Get the value of RptDt
     */
    public function getRptDt(): ?RptDt
    {
        return $this->rptDt;
    }

    public function setRptDt(RptDt $rptDt)
    {
        unset($this->rptDt);
        $this->rptDt = $rptDt->toArray();

        return $this;
    }

     /**
     * Get the value of TckrSymb
     */
    public function getTckrSymb(): ?TckrSymb
    {
        return $this->tckrSymb;
    }

    public function setTckrSymb(TckrSymb $tckrSymb)
    {
        unset($this->tckrSymb);
        $this->tckrSymb = $tckrSymb->toArray();

        return $this;
    }

    /**
     * Get the value of MktNm
     */
    public function getMktNm(): ?MktNm
    {
        return $this->mktNm;
    }

    public function setMktNm(MktNm $mktNm)
    {
        unset($this->mktNm);
        $this->mktNm = $mktNm->toArray();

        return $this;
    }

    /**
     * Get the value of SctyCtgyNm
     */
    public function getSctyCtgyNm(): ?SctyCtgyNm
    {
        return $this->sctyCtgyNm;
    }

    public function setSctyCtgyNm(SctyCtgyNm $sctyCtgyNm)
    {
        unset($this->sctyCtgyNm);
        $this->sctyCtgyNm = $sctyCtgyNm->toArray();

        return $this;
    }

    /**
     * Get the value of ISIN
     */
    public function getIsin(): ?ISIN
    {
        return $this->isin;
    }

    public function setIsin(ISIN $isin)
    {
        unset($this->isin);
        $this->isin = $isin->toArray();

        return $this;
    }

    /**
     * Get the value of CrpnNm
     */
    public function getCrpnNm(): ?CrpnNm
    {
        return $this->crpnNm;
    }

    public function setCrpnNm(CrpnNm $crpnNm)
    {
        unset($this->crpnNm);
        $this->crpnNm = $crpnNm->toArray();

        return $this;
    }
}
