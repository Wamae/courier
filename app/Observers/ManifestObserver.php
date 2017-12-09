<?php

namespace App\Observers;

use Log;

class ManifestObserver {
    public function updating($manifest) {
        Log::info("updating manifest...");
        $manifest->manifest_no = $this->create_manifest_no($manifest->origins->office_code, $manifest->destinations->office_code, $manifest->id);
    }
    
    public function created($manifest) {
        Log::info("creating manifest...");
        $manifest->manifest_no = $this->create_manifest_no($manifest->origins->office_code, $manifest->destinations->office_code, $manifest->id);
        $manifest->save();
    }

    public function create_manifest_no($o_office_code, $d_office_code, $id) {
        return $o_office_code . "-" . $d_office_code . "-MANIFEST:" . $id;
    }

}
