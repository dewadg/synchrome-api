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
        $fingerprint_count = Fingerprint::where('asn_id', $asn_id)->count();

        return Fingerprint::create([
            'asn_id' => $asn_id,
            'idx' => ($fingerprint_count + 1),
            'alg_ver' => $data['alg_ver'],
            'template' => $data['template'],
        ]);
    }

    /**
     * Delete a fingerprint.
     *
     * @param $id
     * @return boolean
     */
    public function delete($asn_id, $id)
    {
        return Fingerprint::where([
            'id' => $id,
            'asn_id' => $asn_id,
        ])->firstOrFail()
        ->delete();
    }
}
