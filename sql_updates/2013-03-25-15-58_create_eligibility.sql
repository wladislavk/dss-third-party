CREATE TABLE `dental_eligibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11),
  `userid` int(11),
  `request_date` datetime,
  `eligible_id` varchar(255),
  `pi_name` varchar(255),
  `pi_id` int(11),
  `pi_group_name` varchar(255),
  `pi_plan_begins` date,
  `pi_plan_ends` date,
  `pi_comments` text,
  `pi_deductible_in_individual_base_period` decimal(11,2),
  `pi_deductible_in_individual_remaining` decimal(11,2),
  `pi_deductible_in_individual_comments` text,
  `pi_deductible_in_family_base_period` decimal(11,2),
  `pi_deductible_in_family_remaining` decimal(11,2),
  `pi_deductible_in_family_comments` text,  
  `pi_deductible_out_individual_base_period` decimal(11,2),
  `pi_deductible_out_individual_remaining` decimal(11,2),
  `pi_deductible_out_individual_comments` text, 
  `pi_deductible_out_family_base_period` decimal(11,2),
  `pi_deductible_out_family_remaining` decimal(11,2),
  `pi_deductible_out_family_comments` text,    
  `pi_stop_loss_in_individual_base_period` decimal(11,2),
  `pi_stop_loss_in_individual_remaining` decimal(11,2),
  `pi_stop_loss_in_individual_comments` text,
  `pi_stop_loss_in_family_base_period` decimal(11,2),
  `pi_stop_loss_in_family_remaining` decimal(11,2),
  `pi_stop_loss_in_family_comments` text,    
  `pi_stop_loss_out_individual_base_period` decimal(11,2),
  `pi_stop_loss_out_individual_remaining` decimal(11,2),
  `pi_stop_loss_out_individual_comments` text,
  `pi_stop_loss_out_family_base_period` decimal(11,2),
  `pi_stop_loss_out_family_remaining` decimal(11,2),
  `pi_stop_loss_out_family_comments` text,
  `pi_balance` decimal(11,2),
  `medical_care_coverage_status` int(2),
  `medical_care_coinsurance_in_individual_percent` int(11),
  `medical_care_coinsurance_in_individual_comments` text,
  `medical_care_coinsurance_in_family_percent` int(11),
  `medical_care_coinsurance_in_family_comments` text,
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;



"1": {
    "description": "Medical Care",
    "coverage_status": "1",
    "coinsurance_in_network": {
      "individual": {
        "percent": "",
        "comments": [

        ]
      },
      "family": {
        "percent": "",
        "comments": [

        ]
      }
    },
    "coinsurance_out_network": {
      "individual": {
        "percent": "",
        "comments": [

        ]
      },
      "family": {
        "percent": "",
        "comments": [

        ]
      }
    },
    "copayment_in_network": {
      "individual": {
        "amount": "",
        "comments": [

        ]
      },
      "family": {
        "amount": "",
        "comments": [

        ]
      }
    },
    "copayment_out_network": {
      "individual": {
        "amount": "",
        "comments": [

        ]
      },
      "family": {
        "amount": "",
        "comments": [

        ]
      }
    },
    "deductible_in_network": {
      "individual": {
        "base_period": "",
        "remaining": "",
        "comments": [

        ]
      },
      "family": {
        "base_period": "",
        "remaining": "",
        "comments": [

        ]
      }
    },
    "deductible_out_network": {
      "individual": {
        "base_period": "",
        "remaining": "",
        "comments": [

        ]
      },
      "family": {
        "base_period": "",
        "remaining": "",
        "comments": [

        ]
      }
    },
    "precertification_needed": "",
    "visits_in_network": {
      "individual": {
        "total": "",
        "remaining": "",
        "comments": [

        ]
      },
      "family": {
        "total": "",
        "remaining": "",
        "comments": [

        ]
      }
    },
    "visits_out_network": {
      "individual": {
        "total": "",
        "remaining": "",
        "comments": [

        ]
      },
      "family": {
        "total": "",
        "remaining": "",
        "comments": [

        ]
      }
    },
    "additional_insurance": {
      "comments": [

      ]
    }
  },
