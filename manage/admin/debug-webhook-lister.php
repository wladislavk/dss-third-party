<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/access.php';

if (!is_super($_SESSION['admin_access'])) {
    header('Location: /manage/admin');
    trigger_error('Die called', E_USER_ERROR);
}

function shuffleString ($string, $replacement='') {
    if (!is_string($string)) {
        return $string;
    }

    $string = str_split($string);
    shuffle($string);
    $string = join('', $string);

    $stringLength = strlen($string);
    $replacementLength = strlen($replacement);

    if ($stringLength && $replacementLength) {
        $string = substr("$replacement$string", 0, $stringLength);
    }

    return $string;
}

function applyFilter (&$parent, $rules) {
    $isArray = is_array($parent);
    $isObject = is_object($parent);

    if (!$isArray && !$isObject) {
        return;
    }

    if ($isArray) {
        foreach ($rules as $field => $action) {
            if (isset($parent[$field])) {
                $action($parent[$field], $parent);
            }
        }
    } else {
        foreach ($rules as $field => $action) {
            if (isset($parent->{$field})) {
                $action($parent->{$field}, $parent);
            }
        }
    }

    foreach ($parent as $field => &$child) {
        applyFilter($child, $rules);
    }
}

function filteredJsonDecode ($json) {
    $filterRules = [
        'type_code' => function ($self, &$parent) {
            if (!preg_match('/^TJ|PQ$/', $parent->type_code)) {
                return;
            }

            $parent->value = shuffleString($parent->value, $parent->value === 'TJ' ? '00' : '11');
        },
        'payee' => function (&$self, $parent) {
            $regex = '/^.{2}(.{2}).*(.{2})$/';
            $replacement = '***$1****$2';

            $self->name = preg_replace($regex, $replacement, $self->name);

            foreach (['street_line_1', 'street_line_2'] as $field) {
                $self->address->{$field} = preg_replace($regex, $replacement, $self->address->{$field});
            }

            $self->npi = shuffleString($self->npi, '99');
            $self->address->zip = shuffleString($self->address->zip, '99');
        },
        'service_provider' => function (&$self, $parent) {
            $regex = '/^.*(.{2})$/';
            $replacement = '***$1';
            
            foreach (['first_name', 'last_name'] as $field) {
                $self->{$field} = preg_replace($regex, $replacement, $self->{$field});
            }

            if (isset($self->npi)) {
                $self->npi = shuffleString($self->npi, '99');
            }
        }
    ];
    
    $json = json_decode($json);
    applyFilter($json, $filterRules);
    
    return $json;
}

$eligibleEvents = [];
$eligibleTypes = [
    'claim_created',
    'created',
    'claim_submitted',
    'submitted',
    'claim_received',
    'received',

    'claim_rejected',
    'rejected',

    'claim_accepted',
    'accepted',

    'claim_paid',
    'paid',

    'claim_denied',
    'denied',

    'claim_more_info_required',
    'more_info_required',

    'payment_report',
    'enrollment_status',
    'received_pdf',

    'claim_acknowledgement',

    'payer_list',
    'payer_status',
    'payer_updated',
];

foreach ($eligibleTypes as $eventType) {
    $results = $db->getResults("SELECT response
        FROM dental_eligible_response
        WHERE LENGTH(response)
            AND LENGTH(reference_id)
            AND SUBSTR(reference_id, 1, 5) != 'ECLAIM'
            AND event_type = '$eventType'
        ORDER BY id DESC
        LIMIT 20");
    
    array_walk($results, function(&$each){
        $each = filteredJsonDecode($each['response']);
    });
    
    $eligibleEvents[$eventType] = $results;
}

require_once __DIR__ . '/includes/top.htm';

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
<script>
    jQuery(function($){
        $('pre.json').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
<p class="lead">Lists  webhook events, for debugging.</p>
<p>
    This tool creates A JSON suitable for the Debug Webhook Handler script.
    It's meant to be used to update the proper file when needed.
</p>
<pre class="json"><?= json_encode($eligibleEvents, JSON_PRETTY_PRINT) ?></pre>
