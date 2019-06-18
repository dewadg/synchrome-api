<?php

namespace App\Services;

use App\Fingerprint;

class FingerprintService
{
    /**
     * Register a fingerprint for an ASN.
     *
     * @param $asn_id
     * @param array $data
     * @return Fingerprint
     */
    public function register($asn_id, array $data)
    {
        return Fingerprint::create([
            'asn_id' => $asn_id,
            'idx' => $data['idx'],
            'alg_ver' => $data['alg_ver'],
            'template' => $data['template'],
        ]);
    }
}
