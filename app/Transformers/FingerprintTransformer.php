<?php

namespace App\Transformers;

use App\Fingerprint;
use League\Fractal\TransformerAbstract;

class FingerprintTransformer extends TransformerAbstract
{
    /**
     * Transforms the model.
     *
     * @param Fingerprint $fingerprint
     * @return array
     */
    public function transform(Fingerprint $fingerprint)
    {
        return [
            'idx' => $fingerprint->idx,
            'algVer' => $fingerprint->alg_ver,
            'template' => $fingerprint->template,
        ];
    }
}
