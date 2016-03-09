<?php
namespace Ds3\Libraries\Legacy;

/**
 * Enclose these values in a function to ensure the FO don't have access to them
 *
 * @return array
 */
function webHookEvents () {
    ob_start();

    ?>[{
    "event": "claim_denied",
    "reference_id": "8JCHTD1NQEIYG8",
    "status": "denied",
    "acknowledgements": [{
        "event": "claim_received",
        "reference_id": "8JCHTD1NQEIYG8",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_accepted",
        "reference_id": "8JCHTD1NQEIYG8",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": "1900316055829773000",
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Entity acknowledges receipt of claim/encounter. Note: This code requires use of an Entity Code."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8JCHTD1NQEIYG8",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JCHTD1NQEIYG8",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [{
        "event": "payment_report",
        "reference_id": "8JCHTD1NQEIYG8",
        "id": "8JLJA3IATI1U1A",
        "details": {
            "effective_date": "2016-03-03",
            "payer": {
                "name": "NORIDIAN - DMEMAC JURISDICTION D",
                "id": "DMERC",
                "address": {
                    "street_line_1": "P O BOX 6727",
                    "street_line_2": null,
                    "city": "FARGO",
                    "state": "ND",
                    "zip": "581086727"
                },
                "contacts": [{
                    "department_code": "CX",
                    "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                    "name": "CROSSOVER INQUIRIES",
                    "details": [{
                        "type_code": "TE",
                        "type_label": "Telephone",
                        "value": "8773200390"
                    }, {
                        "type_code": "EM",
                        "type_label": "Electronic Mail",
                        "value": "DME@NORIDIAN.COM"
                    }]
                }, {
                    "department_code": "BL",
                    "department_label": "Technical Department",
                    "name": "CEDI HELP DESK",
                    "details": [{
                        "type_code": "TE",
                        "type_label": "Telephone",
                        "value": "8663119184"
                    }]
                }],
                "crossover_payer": {
                    "name": "MUTUAL OF OMAHA INSURANCE COMP",
                    "id": "30090"
                },
                "corrected_priority_payer": null
            },
            "financials": {
                "type_code": "H",
                "type_label": "Notification Only",
                "total_payment_amount": "0",
                "credit": true,
                "debit": false,
                "payment_method_code": "NON",
                "payment_method_label": "Non-Payment Data",
                "payment_format_code": "",
                "payment_format_label": "",
                "payment_date": "2016-03-08",
                "payment_trace_number": "60683AB6461SYS",
                "sender": {
                    "dfi_id_qualifier": "",
                    "dfi_id_qualifier_label": "",
                    "dfi_id": "",
                    "account_number": "",
                    "id": "",
                    "supplemental_code": ""
                },
                "receiver": {
                    "dfi_id_qualifier": "",
                    "dfi_id_qualifier_label": "",
                    "dfi_id": "",
                    "account_type": "",
                    "account_number": ""
                }
            },
            "payee": {
                "name": "*** R***KE",
                "npi": "971414089",
                "address": {
                    "street_line_1": "***03***AD",
                    "street_line_2": "BUILDING 4",
                    "city": "SAN ANTONIO",
                    "state": "TX",
                    "zip": "782305470"
                },
                "additional_ids": [{
                    "type_code": "TJ",
                    "type_label": "Federal Taxpayer's Identification Number",
                    "value": "126579545"
                }],
                "adjustments": [],
                "delivery_method": null
            },
            "patient": {
                "first_name": "****ARD",
                "last_name": "**CIO",
                "middle_name": "",
                "id": "*******63T"
            },
            "corrected_patient": {
                "first_name": "",
                "last_name": "",
                "middle_name": "",
                "id": "*******63A"
            },
            "other_patient": {
                "first_name": null,
                "last_name": null,
                "middle_name": null,
                "id": null
            },
            "service_provider": null,
            "claim": {
                "control_number": "16055829773000",
                "received_date": "2016-02-24",
                "expiration_date": null,
                "filing_indicator_type": "MB",
                "filing_indicator_label": "Medicare Part B",
                "place_of_service": "12",
                "frequency": "1",
                "responsibility_sequence": "primary",
                "status": ["processed", "forwarded"],
                "drg_code": null,
                "drg_quantity": null,
                "amount": {
                    "billed": 6495.0,
                    "paid": 0.0,
                    "patient_responsibility": 6495.0,
                    "total_coverage": null,
                    "prompt_payment_discount": null,
                    "per_day_limit": null,
                    "patient_paid": null,
                    "revised_interest": null,
                    "negative_ledger_balance": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "adjustments": [],
                "quantity": {
                    "actual": {
                        "covered": null,
                        "co_insured": null,
                        "life_time_reserve": null
                    },
                    "estimated": {
                        "life_time_reserve": null,
                        "non_covered": null
                    },
                    "not_replaced_blood_unit": null,
                    "outlier_days": null,
                    "prescription": null,
                    "visits": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "moa_codes": ["MA18", "MA27", "MA28"],
                "allowed_amount": null,
                "contacts": [],
                "service_lines": [{
                    "procedure_qualifier": "HC",
                    "procedure_code": "E0486",
                    "procedure_modifiers": ["NU", "KX"],
                    "revenue_code": "",
                    "service_start": "2016-02-23",
                    "service_end": "2016-02-23",
                    "amount": {
                        "billed": 6495.0,
                        "paid": 0.0,
                        "total_coverage": 1311.05,
                        "deduction": null,
                        "tax": null,
                        "total_claim_before_taxes": null,
                        "federal": {
                            "category_1": null,
                            "category_2": null,
                            "category_3": null,
                            "category_4": null,
                            "category_5": null
                        }
                    },
                    "quantity": {
                        "billed": 0.0,
                        "paid": 1.0,
                        "federal": {
                            "category_1": null,
                            "category_2": null,
                            "category_3": null,
                            "category_4": null,
                            "category_5": null
                        }
                    },
                    "additional_ids": [{
                        "type_code": "LU",
                        "type_label": "Location Number",
                        "value": "12"
                    }],
                    "rendering_provider_ids": [],
                    "allowed_amount": 1311.05,
                    "remark_codes": [],
                    "provider_control_number": "1",
                    "healthcare_policy": [],
                    "adjustments": [{
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "45",
                        "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                        "amount": 5183.95,
                        "quantity": 0.0
                    }, {
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "253",
                        "reason_label": "Sequestration - reduction in federal spending",
                        "amount": 20.98,
                        "quantity": 0.0
                    }, {
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "100",
                        "reason_label": "Payment made to patient/insured/responsible party/employer.",
                        "amount": 1027.86,
                        "quantity": 0.0
                    }, {
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "2",
                        "reason_label": "Coinsurance Amount",
                        "amount": 262.21,
                        "quantity": 0.0
                    }]
                }]
            }
        },
        "last_updated_at": "2016-03-09T10:00:19Z"
    }],
    "payment_statuses": []
}, {
    "event": "payment_report",
    "reference_id": "8JCHTD1NQEIYG8",
    "id": "8JLJA3IATI1U1A",
    "details": {
        "effective_date": "2016-03-03",
        "payer": {
            "name": "NORIDIAN - DMEMAC JURISDICTION D",
            "id": "DMERC",
            "address": {
                "street_line_1": "P O BOX 6727",
                "street_line_2": null,
                "city": "FARGO",
                "state": "ND",
                "zip": "581086727"
            },
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "CROSSOVER INQUIRIES",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8773200390"
                }, {
                    "type_code": "EM",
                    "type_label": "Electronic Mail",
                    "value": "DME@NORIDIAN.COM"
                }]
            }, {
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "CEDI HELP DESK",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8663119184"
                }]
            }],
            "crossover_payer": {
                "name": "MUTUAL OF OMAHA INSURANCE COMP",
                "id": "30090"
            },
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "H",
            "type_label": "Notification Only",
            "total_payment_amount": "0",
            "credit": true,
            "debit": false,
            "payment_method_code": "NON",
            "payment_method_label": "Non-Payment Data",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "60683AB6461SYS",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "*** R***KE",
            "npi": "971414089",
            "address": {
                "street_line_1": "***03***AD",
                "street_line_2": "BUILDING 4",
                "city": "SAN ANTONIO",
                "state": "TX",
                "zip": "782305470"
            },
            "additional_ids": [{
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "126579545"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "****ARD",
            "last_name": "**CIO",
            "middle_name": "",
            "id": "*******63T"
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******63A"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": null,
        "claim": {
            "control_number": "16055829773000",
            "received_date": "2016-02-24",
            "expiration_date": null,
            "filing_indicator_type": "MB",
            "filing_indicator_label": "Medicare Part B",
            "place_of_service": "12",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed", "forwarded"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 6495.0,
                "paid": 0.0,
                "patient_responsibility": 6495.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [],
            "rendering_provider_ids": [],
            "moa_codes": ["MA18", "MA27", "MA28"],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "E0486",
                "procedure_modifiers": ["NU", "KX"],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 6495.0,
                    "paid": 0.0,
                    "total_coverage": 1311.05,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [{
                    "type_code": "LU",
                    "type_label": "Location Number",
                    "value": "12"
                }],
                "rendering_provider_ids": [],
                "allowed_amount": 1311.05,
                "remark_codes": [],
                "provider_control_number": "1",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 5183.95,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "253",
                    "reason_label": "Sequestration - reduction in federal spending",
                    "amount": 20.98,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "100",
                    "reason_label": "Payment made to patient/insured/responsible party/employer.",
                    "amount": 1027.86,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 262.21,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T10:00:19Z"
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "00051",
        "payer_name": "Virginia Medicaid",
        "transaction_type": "270",
        "status": "available",
        "details": "Payer is working fine.",
        "updated_at": "09-03-2016 08:09",
        "message": null
    }
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "00051",
        "payer_name": "Virginia Medicaid",
        "transaction_type": "270",
        "status": "unavailable",
        "details": "Payer is experiencing high number of failures.",
        "updated_at": "09-03-2016 07:22",
        "message": null
    }
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "SCMED",
        "payer_name": "South Carolina Medicaid  | South Carolina Medicaid",
        "transaction_type": "270",
        "status": "available",
        "details": "Payer is working fine.",
        "updated_at": "09-03-2016 02:14",
        "message": null
    }
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "SCMED",
        "payer_name": "South Carolina Medicaid  | South Carolina Medicaid",
        "transaction_type": "270",
        "status": "unavailable",
        "details": "Payer is experiencing high number of failures.",
        "updated_at": "09-03-2016 02:11",
        "message": null
    }
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "00083",
        "payer_name": "Blue Cross Blue Shield of Louisiana | Louisiana Blue Cross Blue Shield",
        "transaction_type": "270",
        "status": "available",
        "details": "Payer is working fine.",
        "updated_at": "09-03-2016 02:01",
        "message": null
    }
}, {
    "event": "claim_denied",
    "reference_id": "8J7UIF3V6ST0Z9",
    "status": "denied",
    "acknowledgements": [{
        "event": "claim_accepted",
        "reference_id": "8J7UIF3V6ST0Z9",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": null,
            "effective_date": "2016-02-17",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "8J7UIF3V6ST0Z9",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-02-17",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_accepted",
        "reference_id": "8J7UIF3V6ST0Z9",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": null,
            "effective_date": "2016-02-17",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "8J7UIF3V6ST0Z9",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-02-17",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "8J7UIF3V6ST0Z9",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-02-17",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8J7UIF3V6ST0Z9",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-02-17",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8J7UIF3V6ST0Z9",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-02-17",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [{
        "event": "payment_report",
        "reference_id": "8J7UIF3V6ST0Z9",
        "id": "URBXWA6G7Y7IF",
        "details": {
            "effective_date": "2016-03-08",
            "payer": {
                "name": "FLORIDA BLUE",
                "id": "FLBLS",
                "address": {
                    "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                    "street_line_2": null,
                    "city": "JACKSONVILLE",
                    "state": "FL",
                    "zip": "32246"
                },
                "contacts": [{
                    "department_code": "BL",
                    "department_label": "Technical Department",
                    "name": "",
                    "details": [{
                        "type_code": "TE",
                        "type_label": "Telephone",
                        "value": "8007272227"
                    }]
                }],
                "crossover_payer": null,
                "corrected_priority_payer": null
            },
            "financials": {
                "type_code": "H",
                "type_label": "Notification Only",
                "total_payment_amount": "0",
                "credit": true,
                "debit": false,
                "payment_method_code": "NON",
                "payment_method_label": "Non-Payment Data",
                "payment_format_code": "",
                "payment_format_label": "",
                "payment_date": "2016-03-08",
                "payment_trace_number": "1603080575",
                "sender": {
                    "dfi_id_qualifier": "",
                    "dfi_id_qualifier_label": "",
                    "dfi_id": "",
                    "account_number": "",
                    "id": "",
                    "supplemental_code": ""
                },
                "receiver": {
                    "dfi_id_qualifier": "",
                    "dfi_id_qualifier_label": "",
                    "dfi_id": "",
                    "account_type": "",
                    "account_number": ""
                }
            },
            "payee": {
                "name": "***RG***OS",
                "npi": "948114120",
                "address": {
                    "street_line_1": "*** 4*** W",
                    "street_line_2": "STE A",
                    "city": "BRADENTON",
                    "state": "FL",
                    "zip": "34209"
                },
                "additional_ids": [{
                    "type_code": "PQ",
                    "type_label": "Payee Identification",
                    "value": "0420591"
                }, {
                    "type_code": "TJ",
                    "type_label": "Federal Taxpayer's Identification Number",
                    "value": "157621401"
                }],
                "adjustments": [],
                "delivery_method": null
            },
            "patient": {
                "first_name": "**VID",
                "last_name": "**KES",
                "middle_name": "",
                "id": "*********751"
            },
            "corrected_patient": {
                "first_name": null,
                "last_name": null,
                "middle_name": null,
                "id": null
            },
            "other_patient": {
                "first_name": null,
                "last_name": null,
                "middle_name": null,
                "id": null
            },
            "service_provider": {
                "first_name": "****RGE",
                "last_name": "****ROS",
                "middle_name": "S",
                "npi": "948114120"
            },
            "claim": {
                "control_number": "H100000517066245",
                "received_date": "2016-02-17",
                "expiration_date": null,
                "filing_indicator_type": "12",
                "filing_indicator_label": "Preferred Provider Organization (PPO)",
                "place_of_service": null,
                "frequency": null,
                "responsibility_sequence": "primary",
                "status": ["processed"],
                "drg_code": null,
                "drg_quantity": null,
                "amount": {
                    "billed": 6500.0,
                    "paid": 0.0,
                    "patient_responsibility": 0.0,
                    "total_coverage": null,
                    "prompt_payment_discount": null,
                    "per_day_limit": null,
                    "patient_paid": null,
                    "revised_interest": null,
                    "negative_ledger_balance": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "adjustments": [],
                "quantity": {
                    "actual": {
                        "covered": null,
                        "co_insured": null,
                        "life_time_reserve": null
                    },
                    "estimated": {
                        "life_time_reserve": null,
                        "non_covered": null
                    },
                    "not_replaced_blood_unit": null,
                    "outlier_days": null,
                    "prescription": null,
                    "visits": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [{
                    "type_code": "F8",
                    "type_label": "Original Reference Number",
                    "value": "H100000517066245"
                }],
                "rendering_provider_ids": [],
                "moa_codes": [],
                "allowed_amount": null,
                "contacts": [],
                "service_lines": [{
                    "procedure_qualifier": "HC",
                    "procedure_code": "E0486",
                    "procedure_modifiers": ["NU", "KX"],
                    "revenue_code": "",
                    "service_start": "2016-02-16",
                    "service_end": "2016-02-16",
                    "amount": {
                        "billed": 6500.0,
                        "paid": 0.0,
                        "total_coverage": 6500.0,
                        "deduction": null,
                        "tax": null,
                        "total_claim_before_taxes": null,
                        "federal": {
                            "category_1": null,
                            "category_2": null,
                            "category_3": null,
                            "category_4": null,
                            "category_5": null
                        }
                    },
                    "quantity": {
                        "billed": 1.0,
                        "paid": 0.0,
                        "federal": {
                            "category_1": null,
                            "category_2": null,
                            "category_3": null,
                            "category_4": null,
                            "category_5": null
                        }
                    },
                    "additional_ids": [],
                    "rendering_provider_ids": [],
                    "allowed_amount": 6500.0,
                    "remark_codes": [{
                        "type_code": "HE",
                        "type_label": "Claim Payment Remark Codes",
                        "value": "N199"
                    }, {
                        "type_code": "HE",
                        "type_label": "Claim Payment Remark Codes",
                        "value": "N522"
                    }],
                    "provider_control_number": "1",
                    "healthcare_policy": [],
                    "adjustments": [{
                        "type_code": "OA",
                        "type_label": "Other adjustments",
                        "reason_code": "18",
                        "reason_label": "Exact duplicate claim/service (Use only with Group Code OA except where state workers' compensation regulations requires CO)",
                        "amount": 6500.0,
                        "quantity": 0.0
                    }]
                }]
            }
        },
        "last_updated_at": "2016-03-09T02:01:04Z"
    }],
    "payment_statuses": []
}, {
    "event": "payment_report",
    "reference_id": "8J7UIF3V6ST0Z9",
    "id": "URBXWA6G7Y7IF",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": "FLBLS",
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "H",
            "type_label": "Notification Only",
            "total_payment_amount": "0",
            "credit": true,
            "debit": false,
            "payment_method_code": "NON",
            "payment_method_label": "Non-Payment Data",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "1603080575",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***RG***OS",
            "npi": "948114120",
            "address": {
                "street_line_1": "*** 4*** W",
                "street_line_2": "STE A",
                "city": "BRADENTON",
                "state": "FL",
                "zip": "34209"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "157621401"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**VID",
            "last_name": "**KES",
            "middle_name": "",
            "id": "*********751"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****RGE",
            "last_name": "****ROS",
            "middle_name": "S",
            "npi": "948114120"
        },
        "claim": {
            "control_number": "H100000517066245",
            "received_date": "2016-02-17",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 6500.0,
                "paid": 0.0,
                "patient_responsibility": 0.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "H100000517066245"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "E0486",
                "procedure_modifiers": ["NU", "KX"],
                "revenue_code": "",
                "service_start": "2016-02-16",
                "service_end": "2016-02-16",
                "amount": {
                    "billed": 6500.0,
                    "paid": 0.0,
                    "total_coverage": 6500.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 6500.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N199"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N522"
                }],
                "provider_control_number": "1",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "OA",
                    "type_label": "Other adjustments",
                    "reason_code": "18",
                    "reason_label": "Exact duplicate claim/service (Use only with Group Code OA except where state workers' compensation regulations requires CO)",
                    "amount": 6500.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:04Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "8JLBEXZI03ZOMC",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "80",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "184252935",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***THA",
            "last_name": "***RAY",
            "middle_name": "L",
            "id": "******858"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519898344",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 112.0,
                "paid": 0.0,
                "patient_responsibility": 112.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519898344"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D2150",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 112.0,
                    "paid": 0.0,
                    "total_coverage": 112.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 112.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N448"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 112.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:02Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "8JLBEXYNFH4GSX",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "80",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "184252935",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**UIS",
            "last_name": "*****ITO",
            "middle_name": "M",
            "id": "******340"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519893787",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 112.0,
                "paid": 0.0,
                "patient_responsibility": 112.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519893787"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D2150",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 112.0,
                    "paid": 0.0,
                    "total_coverage": 112.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 112.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N448"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 112.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:02Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "8JLBEXXMPJ0IN8",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "80",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "184252935",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***MAS",
            "last_name": "*****NTS",
            "middle_name": "J",
            "id": "******852"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519893807",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 113.0,
                "paid": 28.0,
                "patient_responsibility": 66.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519893807"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 74.0,
                    "paid": 16.0,
                    "total_coverage": 59.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 59.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 15.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 43.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "HC",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 39.0,
                    "paid": 12.0,
                    "total_coverage": 35.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 35.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 4.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 23.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "URBXW6USZ6MN9",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "80",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "184252935",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*ALE",
            "last_name": "*****NTS",
            "middle_name": "",
            "id": "******852"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519898345",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 113.0,
                "paid": 28.0,
                "patient_responsibility": 66.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519898345"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 74.0,
                    "paid": 16.0,
                    "total_coverage": 59.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 59.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 15.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 43.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "HC",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 39.0,
                    "paid": 12.0,
                    "total_coverage": 35.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 35.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 4.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 23.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "URBXW6RDHJ5Q0",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "80",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "184252935",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**DDY",
            "last_name": "****EDY",
            "middle_name": "H",
            "id": "******327"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519898883",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 89.0,
                "paid": 24.0,
                "patient_responsibility": 50.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519898883"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 74.0,
                    "paid": 16.0,
                    "total_coverage": 59.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 59.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 15.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 43.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "HC",
                "procedure_code": "D1208",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 15.0,
                    "paid": 8.0,
                    "total_coverage": 15.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 15.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 7.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "8JLBEXULI5CT88",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "80",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "184252935",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**RIA",
            "last_name": "***VES",
            "middle_name": "E",
            "id": "******844"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519893805",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 112.0,
                "paid": 0.0,
                "patient_responsibility": 112.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519893805"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D2150",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 112.0,
                    "paid": 0.0,
                    "total_coverage": 112.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 112.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N448"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 112.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "8JLBEXT5RQ6KAA",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "212",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "151050024",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*****NCE",
            "last_name": "***ANT",
            "middle_name": "L",
            "id": "******157"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519893789",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 74.0,
                "paid": 59.0,
                "patient_responsibility": 0.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519893789"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-22",
                "service_end": "2016-02-22",
                "amount": {
                    "billed": 74.0,
                    "paid": 59.0,
                    "total_coverage": 59.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 59.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 15.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "URBXW6EZD75RW",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "212",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "151050024",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**ANE",
            "last_name": "***ANT",
            "middle_name": "",
            "id": "******157"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519893790",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 74.0,
                "paid": 59.0,
                "patient_responsibility": 0.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519893790"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-22",
                "service_end": "2016-02-22",
                "amount": {
                    "billed": 74.0,
                    "paid": 59.0,
                    "total_coverage": 59.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 59.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 15.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "8JLBEXQPDQMWXC",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "212",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "151050024",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*AIL",
            "last_name": "*****ARD",
            "middle_name": "",
            "id": "******964"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519898342",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 112.0,
                "paid": 0.0,
                "patient_responsibility": 112.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519898342"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D2150",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-25",
                "service_end": "2016-02-25",
                "amount": {
                    "billed": 112.0,
                    "paid": 0.0,
                    "total_coverage": 112.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 112.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N448"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 112.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "8JLBEXPVXST96B",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "212",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "151050024",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*OHN",
            "last_name": "***LER",
            "middle_name": "J",
            "id": "******737"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519893788",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 212.0,
                "paid": 0.0,
                "patient_responsibility": 212.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519893788"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D5650",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 107.0,
                    "paid": 0.0,
                    "total_coverage": 107.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 107.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N448"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 107.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "HC",
                "procedure_code": "D7140",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 105.0,
                    "paid": 0.0,
                    "total_coverage": 105.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 105.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N448"
                }, {
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 105.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "payment_report",
    "reference_id": "000000000",
    "id": "B2N0OJGUX7ZB",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "FLORIDA BLUE",
            "id": null,
            "address": {
                "street_line_1": "4800 DEERWOOD CAMPUS PARKWAY",
                "street_line_2": null,
                "city": "JACKSONVILLE",
                "state": "FL",
                "zip": "32246"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8007272227"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "212",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "151050024",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***GL***PA",
            "npi": "993615870",
            "address": {
                "street_line_1": "***1 ***WY",
                "street_line_2": null,
                "city": "INVERNESS",
                "state": "FL",
                "zip": "344533210"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "410952"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "125059997"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*ADE",
            "last_name": "***LER",
            "middle_name": "",
            "id": "******737"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****LAS",
            "last_name": "****ART",
            "middle_name": "",
            "npi": "941411442"
        },
        "claim": {
            "control_number": "F100000519898347",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 101.0,
                "paid": 94.0,
                "patient_responsibility": 0.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "F8",
                "type_label": "Original Reference Number",
                "value": "F100000519898347"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 62.0,
                    "paid": 59.0,
                    "total_coverage": 59.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 59.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 3.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "HC",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 39.0,
                    "paid": 35.0,
                    "total_coverage": 35.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 35.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N381"
                }],
                "provider_control_number": null,
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 4.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T02:01:01Z"
}, {
    "event": "claim_accepted",
    "reference_id": "8JL60INMOIWAGI",
    "details": {
        "submission_status": "accepted",
        "payer_control_number": "EP030816790707605",
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A2",
            "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
            "status_code": "20",
            "status_label": "Claim/encounter has been forwarded to entity. Note: This code requires use of an Entity Code."
        }
    }
}, {
    "event": "claim_accepted",
    "reference_id": "8JL60INMOIWAGI",
    "status": "accepted",
    "acknowledgements": [{
        "event": "claim_accepted",
        "reference_id": "8JL60INMOIWAGI",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": "EP030816790707605",
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Claim/encounter has been forwarded to entity. Note: This code requires use of an Entity Code."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "8JL60INMOIWAGI",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8JL60INMOIWAGI",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL60INMOIWAGI",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_accepted",
    "reference_id": "B2MSR1X0QYP1",
    "status": "accepted",
    "acknowledgements": [{
        "event": "claim_accepted",
        "reference_id": "B2MSR1X0QYP1",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": "EP030816790413738",
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Claim/encounter has been forwarded to entity. Note: This code requires use of an Entity Code."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "B2MSR1X0QYP1",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "B2MSR1X0QYP1",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "B2MSR1X0QYP1",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_accepted",
    "reference_id": "B2MSR1X0QYP1",
    "details": {
        "submission_status": "accepted",
        "payer_control_number": "EP030816790413738",
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A2",
            "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
            "status_code": "20",
            "status_label": "Claim/encounter has been forwarded to entity. Note: This code requires use of an Entity Code."
        }
    }
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "00039",
        "payer_name": "Anthem Blue Cross California | California Anthem Blue Cross (WellPoint Health Network)",
        "transaction_type": "270",
        "status": "available",
        "details": "Payer is working fine.",
        "updated_at": "09-03-2016 00:44",
        "message": null
    }
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "00039",
        "payer_name": "Anthem Blue Cross California | California Anthem Blue Cross (WellPoint Health Network)",
        "transaction_type": "270",
        "status": "unavailable",
        "details": "Payer is experiencing high number of failures.",
        "updated_at": "09-03-2016 00:43",
        "message": null
    }
}, {
    "event": "claim_received",
    "reference_id": "URBGBQ0HV278B",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "19",
            "status_label": "Entity acknowledges receipt of claim/encounter."
        }
    }
}, {
    "event": "claim_received",
    "reference_id": "URBGBQ0HV278B",
    "status": "received",
    "acknowledgements": [{
        "event": "claim_received",
        "reference_id": "URBGBQ0HV278B",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "19",
                "status_label": "Entity acknowledges receipt of claim/encounter."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "URBGBQ0HV278B",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "URBGBQ0HV278B",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "URBGBQ0HV278B",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_received",
    "reference_id": "URBGBQ0HV278B",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_accepted",
    "reference_id": "8JL63510NPBG5W",
    "details": {
        "submission_status": "accepted",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A2",
            "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_received",
    "reference_id": "8JL63510NPBG5W",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_received",
    "reference_id": "8JL7GQINVMV6H9",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_accepted",
    "reference_id": "8JL7GQINVMV6H9",
    "status": "accepted",
    "acknowledgements": [{
        "event": "claim_received",
        "reference_id": "8JL7GQINVMV6H9",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_accepted",
        "reference_id": "8JL7GQINVMV6H9",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": "1900316069800006000",
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Entity acknowledges receipt of claim/encounter. Note: This code requires use of an Entity Code."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8JL7GQINVMV6H9",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL7GQINVMV6H9",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_accepted",
    "reference_id": "8JL7GQINVMV6H9",
    "details": {
        "submission_status": "accepted",
        "payer_control_number": "1900316069800006000",
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A2",
            "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
            "status_code": "20",
            "status_label": "Entity acknowledges receipt of claim/encounter. Note: This code requires use of an Entity Code."
        }
    }
}, {
    "event": "payment_report",
    "reference_id": "636231811",
    "id": "URBQRXZA2RUWB",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1109",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024958109",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***K ***PC",
            "npi": "909218392",
            "address": {
                "street_line_1": "***8 ***ST",
                "street_line_2": null,
                "city": "ELKHORN",
                "state": "NE",
                "zip": "680222889"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "465054360"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "150527206"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**LAN",
            "last_name": "*****SKA",
            "middle_name": "",
            "id": "******025"
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******922"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ARK",
            "last_name": "****SEN",
            "middle_name": "A",
            "npi": "909218392"
        },
        "claim": {
            "control_number": "EVJLRD8L50001",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 121.0,
                "paid": 117.0,
                "patient_responsibility": 4.0,
                "total_coverage": 121.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0012000-010-00507- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 121.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8772773368"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D0220",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 28.0,
                    "paid": 28.0,
                    "total_coverage": 28.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 28.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0230",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 28.0,
                    "paid": 24.0,
                    "total_coverage": 24.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 24.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 4.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0140",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 65.0,
                    "paid": 65.0,
                    "total_coverage": 65.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 65.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": []
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:32Z"
}, {
    "event": "payment_report",
    "reference_id": "636231811",
    "id": "8JL9FRE4GU3DTH",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1109",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024958109",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***K ***PC",
            "npi": "909218392",
            "address": {
                "street_line_1": "***8 ***ST",
                "street_line_2": null,
                "city": "ELKHORN",
                "state": "NE",
                "zip": "680222889"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "465054360"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "150527206"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**LAN",
            "last_name": "*****SKA",
            "middle_name": "",
            "id": "******025"
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******922"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ARK",
            "last_name": "****SEN",
            "middle_name": "A",
            "npi": "909218392"
        },
        "claim": {
            "control_number": "EVJLRD8L50000",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 705.0,
                "paid": 560.0,
                "patient_responsibility": 145.0,
                "total_coverage": 705.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0012000-010-00507- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 705.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8772773368"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2392",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 195.0,
                    "paid": 116.0,
                    "total_coverage": 195.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 195.0,
                "remark_codes": [],
                "provider_control_number": "00000000009",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "1",
                    "reason_label": "Deductible Amount",
                    "amount": 50.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 29.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2391",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 165.0,
                    "paid": 132.0,
                    "total_coverage": 165.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 165.0,
                "remark_codes": [],
                "provider_control_number": "00000000008",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 33.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2391",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 165.0,
                    "paid": 132.0,
                    "total_coverage": 165.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 165.0,
                "remark_codes": [],
                "provider_control_number": "00000000007",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 33.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0330",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 102.0,
                    "paid": 102.0,
                    "total_coverage": 102.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 102.0,
                "remark_codes": [],
                "provider_control_number": "00000000006",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 55.0,
                    "paid": 55.0,
                    "total_coverage": 55.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 55.0,
                "remark_codes": [],
                "provider_control_number": "00000000005",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0230",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-24",
                "service_end": "2016-02-24",
                "amount": {
                    "billed": 23.0,
                    "paid": 23.0,
                    "total_coverage": 23.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 23.0,
                "remark_codes": [],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": []
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:32Z"
}, {
    "event": "payment_report",
    "reference_id": "636524117",
    "id": "URBQRXJYRT42A",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1109",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024958109",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***K ***PC",
            "npi": "909218392",
            "address": {
                "street_line_1": "***8 ***ST",
                "street_line_2": null,
                "city": "ELKHORN",
                "state": "NE",
                "zip": "680222889"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "465054360"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "150527206"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**LAN",
            "last_name": "*****SKA",
            "middle_name": "",
            "id": "******025"
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******922"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ARK",
            "last_name": "****SEN",
            "middle_name": "A",
            "npi": "909218392"
        },
        "claim": {
            "control_number": "EK35R6R230000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 390.0,
                "paid": 312.0,
                "patient_responsibility": 78.0,
                "total_coverage": 390.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0012000-010-00507- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 390.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8772773368"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2392",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 195.0,
                    "paid": 156.0,
                    "total_coverage": 195.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 195.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 39.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2392",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 195.0,
                    "paid": 156.0,
                    "total_coverage": 195.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 195.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 39.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:32Z"
}, {
    "event": "payment_report",
    "reference_id": "636524109",
    "id": "8JL9FRAOZFASU2",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1109",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024958109",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***K ***PC",
            "npi": "909218392",
            "address": {
                "street_line_1": "***8 ***ST",
                "street_line_2": null,
                "city": "ELKHORN",
                "state": "NE",
                "zip": "680222889"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "465054360"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "150527206"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*******PHE",
            "last_name": "****ING",
            "middle_name": "R",
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ARK",
            "last_name": "****SEN",
            "middle_name": "A",
            "npi": "909218392"
        },
        "claim": {
            "control_number": "EJY0R8DWS0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 120.0,
                "paid": 120.0,
                "patient_responsibility": 0.0,
                "total_coverage": 120.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0868157-013-00001-PD"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 120.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8886323862"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 75.0,
                    "paid": 75.0,
                    "total_coverage": 75.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 75.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 45.0,
                    "paid": 45.0,
                    "total_coverage": 45.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 45.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": []
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:32Z"
}, {
    "event": "claim_received",
    "reference_id": "32QC629C3ZPJO",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "payment_report",
    "reference_id": "636972691",
    "id": "32QDH6KQNKD58",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "144",
            "credit": true,
            "debit": false,
            "payment_method_code": "ACH",
            "payment_method_label": "Automated Clearing House (ACH)",
            "payment_format_code": "CCP",
            "payment_format_label": "Cash Concentration/Disbursement plus Addenda (CCD+) (ACH)",
            "payment_date": "2016-03-11",
            "payment_trace_number": "816067500003063",
            "sender": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "031100209",
                "account_number": "0000009108",
                "id": "1066033492",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "111901014",
                "account_type": "Demand Deposit",
                "account_number": "3622021004"
            }
        },
        "payee": {
            "name": "***EN*** P",
            "npi": "992518606",
            "address": {
                "street_line_1": "*** W***70",
                "street_line_2": null,
                "city": "ALLEN",
                "state": "TX",
                "zip": "750137020"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "063747270"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "126229207"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**LIP",
            "last_name": "*****TIN",
            "middle_name": "R",
            "id": "*******739"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ITA",
            "last_name": "****NGH",
            "middle_name": "",
            "npi": "992518606"
        },
        "claim": {
            "control_number": "E9JBQ9PYJ0000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 272.0,
                "paid": 144.0,
                "patient_responsibility": 60.0,
                "total_coverage": 272.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0876398-010-00005- B"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01866"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 272.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2160",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-04",
                "service_end": "2016-02-04",
                "amount": {
                    "billed": 146.0,
                    "paid": 83.2,
                    "total_coverage": 128.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 128.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 18.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 24.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 20.8,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2391",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-04",
                "service_end": "2016-02-04",
                "amount": {
                    "billed": 126.0,
                    "paid": 60.8,
                    "total_coverage": 76.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 76.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 50.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 15.2,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2792",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-03",
                "service_end": "2016-03-03",
                "amount": {
                    "billed": 0.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": []
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:29Z"
}, {
    "event": "claim_rejected",
    "reference_id": "32QC629C3ZPJO",
    "status": "rejected",
    "acknowledgements": [{
        "event": "claim_rejected",
        "reference_id": "32QC629C3ZPJO",
        "details": {
            "submission_status": "rejected",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A3",
                "category_label": "Acknowledgement/Returned as unprocessable claim-The claim/encounter has been rejected and has not been entered into the adjudication system.",
                "status_code": "247",
                "status_label": "Line information."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "32QC629C3ZPJO",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "32QC629C3ZPJO",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_rejected",
    "reference_id": "32QC629C3ZPJO",
    "details": {
        "submission_status": "rejected",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A3",
            "category_label": "Acknowledgement/Returned as unprocessable claim-The claim/encounter has been rejected and has not been entered into the adjudication system.",
            "status_code": "247",
            "status_label": "Line information."
        }
    }
}, {
    "event": "payment_report",
    "reference_id": "0",
    "id": "8JL9FPQOH2JT0K",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "51.6",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08333-003753444",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ER***ER",
            "npi": "906912967",
            "address": {
                "street_line_1": "***0 ***36",
                "street_line_2": null,
                "city": "AVON",
                "state": "IN",
                "zip": "46123"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "575948450"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "110139852"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*****NNA",
            "last_name": "*****IPS",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "******FER",
            "last_name": "",
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERT",
            "last_name": "****HER",
            "middle_name": "B",
            "npi": "949216877"
        },
        "claim": {
            "control_number": "EWFBRGL230000",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "secondary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 154.0,
                "paid": 51.6,
                "patient_responsibility": 0.0,
                "total_coverage": 154.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [{
                "type_code": "OA",
                "type_label": "Other adjustments",
                "reason_code": "23",
                "reason_label": "The impact of prior payer(s) adjudication including payments and/or adjustments. (Use only with Group Code OA)",
                "amount": 59.4,
                "quantity": 0.0
            }],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0847174-015-00001-GA"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01858"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 154.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-15",
                "service_end": "2016-02-15",
                "amount": {
                    "billed": 98.0,
                    "paid": 71.0,
                    "total_coverage": 71.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 71.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 27.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-15",
                "service_end": "2016-02-15",
                "amount": {
                    "billed": 56.0,
                    "paid": 40.0,
                    "total_coverage": 40.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 40.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 16.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:28Z"
}, {
    "event": "payment_report",
    "reference_id": "0",
    "id": "URBQRRICCNIZL",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "441",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08608-042928742",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ER***ER",
            "npi": "906912967",
            "address": {
                "street_line_1": "***0 ***36",
                "street_line_2": null,
                "city": "AVON",
                "state": "IN",
                "zip": "46123"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "575948450"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "110139852"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*****LLE",
            "last_name": "**LFE",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "W",
            "id": "*******164"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERT",
            "last_name": "****HER",
            "middle_name": "B",
            "npi": "949216877"
        },
        "claim": {
            "control_number": "E6PBRH0SM0000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 1156.0,
                "paid": 441.0,
                "patient_responsibility": 394.0,
                "total_coverage": 1156.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0868204-020-00000-CO"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01858"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 1156.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8886323862"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2752",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 1156.0,
                    "paid": 441.0,
                    "total_coverage": 835.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 835.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 321.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "1",
                    "reason_label": "Deductible Amount",
                    "amount": 100.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 294.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:27Z"
}, {
    "event": "payment_report",
    "reference_id": "636544001",
    "id": "8JL9FPMC22XGCK",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "74.6",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08608-042927852",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ES***JR",
            "npi": "978115382",
            "address": {
                "street_line_1": "***7 ***CE",
                "street_line_2": null,
                "city": "COVINGTON",
                "state": "LA",
                "zip": "704334955"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "828113800"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "102279920"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*OHN",
            "last_name": "*****RJR",
            "middle_name": "M",
            "id": "********601"
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "********RJR",
            "middle_name": "",
            "id": "*******360"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****NON",
            "last_name": "****YLE",
            "middle_name": "O",
            "npi": "978115382"
        },
        "claim": {
            "control_number": "EPPBR6S4V0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 272.0,
                "paid": 74.6,
                "patient_responsibility": 159.4,
                "total_coverage": 272.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0810002-023-00001-EL"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 03660"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 272.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2150",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 242.0,
                    "paid": 53.6,
                    "total_coverage": 213.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 213.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 29.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 96.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "1",
                    "reason_label": "Deductible Amount",
                    "amount": 50.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 13.4,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0220",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 30.0,
                    "paid": 21.0,
                    "total_coverage": 21.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 21.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 9.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:27Z"
}, {
    "event": "payment_report",
    "reference_id": "0000470030029466P",
    "id": "8JL9FPHG4Z6DSU",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "244",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08608-042926071",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***PH***MD",
            "npi": "973613564",
            "address": {
                "street_line_1": "*** W*** D",
                "street_line_2": null,
                "city": "SPARTA",
                "state": "NJ",
                "zip": "078712300"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "389104480"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "174016454"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "****RIE",
            "last_name": "****RDO",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "M",
            "id": "*******753"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****HEN",
            "last_name": "****DIO",
            "middle_name": "J",
            "npi": "973613564"
        },
        "claim": {
            "control_number": "EWFBRD94N0000",
            "received_date": "2016-03-01",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 162.0,
                "paid": 122.0,
                "patient_responsibility": 0.0,
                "total_coverage": 162.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0754454-031-00000- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Freedom of Choice NET 07787"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 162.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1330",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 0.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 100.0,
                    "paid": 80.0,
                    "total_coverage": 80.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 80.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 62.0,
                    "paid": 42.0,
                    "total_coverage": 42.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 42.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:27Z"
}, {
    "event": "payment_report",
    "reference_id": "0000709010029516P",
    "id": "8JL9FPGK1IXWEE",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "244",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08608-042926071",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***PH***MD",
            "npi": "973613564",
            "address": {
                "street_line_1": "*** W*** D",
                "street_line_2": null,
                "city": "SPARTA",
                "state": "NJ",
                "zip": "078712300"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "389104480"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "174016454"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*ICK",
            "last_name": "********ONE",
            "middle_name": "",
            "id": "*******094"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****HEN",
            "last_name": "****DIO",
            "middle_name": "J",
            "npi": "973613564"
        },
        "claim": {
            "control_number": "EFFBR9B410000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 162.0,
                "paid": 122.0,
                "patient_responsibility": 0.0,
                "total_coverage": 162.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0881312-031-00002-AB"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 07787"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 162.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1330",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 0.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 100.0,
                    "paid": 80.0,
                    "total_coverage": 80.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 80.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 62.0,
                    "paid": 42.0,
                    "total_coverage": 42.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 42.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:27Z"
}, {
    "event": "payment_report",
    "reference_id": "SW32Q2D3V",
    "id": "URBQRP3GNYUAE",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "83",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08384-008002597",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***AN***DS",
            "npi": "927012170",
            "address": {
                "street_line_1": "***BO***30",
                "street_line_2": null,
                "city": "VILONIA",
                "state": "AR",
                "zip": "721730130"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "589250300"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "109129103"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**ONG",
            "last_name": "***MAS",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "C",
            "id": "*******427"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****IAN",
            "last_name": "****ANE",
            "middle_name": "",
            "npi": "927012170"
        },
        "claim": {
            "control_number": "EJABR81NN0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 98.0,
                "paid": 83.0,
                "patient_responsibility": 0.0,
                "total_coverage": 98.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0881942-033-00603- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01920"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 98.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 62.0,
                    "paid": 54.0,
                    "total_coverage": 54.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 54.0,
                "remark_codes": [],
                "provider_control_number": "2",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 8.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 36.0,
                    "paid": 29.0,
                    "total_coverage": 29.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 29.0,
                "remark_codes": [],
                "provider_control_number": "1",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 7.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:25Z"
}, {
    "event": "payment_report",
    "reference_id": "0",
    "id": "32QDH637UY4EA",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "949.25",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08384-008001019",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***PH***MD",
            "npi": "973613564",
            "address": {
                "street_line_1": "*** W*** D",
                "street_line_2": null,
                "city": "SPARTA",
                "state": "NJ",
                "zip": "078712300"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "389104480"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "174016454"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "****HEN",
            "last_name": "*IOR",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "M",
            "id": "*******072"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****HEN",
            "last_name": "****DIO",
            "middle_name": "J",
            "npi": "973613564"
        },
        "claim": {
            "control_number": "E0Y0RDJMV0000",
            "received_date": "2016-02-29",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 1900.0,
                "paid": 666.25,
                "patient_responsibility": 358.75,
                "total_coverage": 1900.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0812310-012-00001- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 07787"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 1900.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2950",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 300.0,
                    "paid": 113.75,
                    "total_coverage": 175.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 175.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 125.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 61.25,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2740",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 1600.0,
                    "paid": 552.5,
                    "total_coverage": 850.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 850.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 750.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 297.5,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:25Z"
}, {
    "event": "payment_report",
    "reference_id": "0000905010029490P",
    "id": "32QDH62931Y7Q",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "949.25",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08384-008001019",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***PH***MD",
            "npi": "973613564",
            "address": {
                "street_line_1": "*** W*** D",
                "street_line_2": null,
                "city": "SPARTA",
                "state": "NJ",
                "zip": "078712300"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "389104480"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "174016454"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "******INE",
            "last_name": "***LEY",
            "middle_name": "",
            "id": "*******962"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****HEN",
            "last_name": "****DIO",
            "middle_name": "J",
            "npi": "973613564"
        },
        "claim": {
            "control_number": "EYPBRDJT50000",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 262.0,
                "paid": 161.0,
                "patient_responsibility": 0.0,
                "total_coverage": 262.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0812310-015-00003- D"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 07787"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 262.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1330",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 0.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 100.0,
                    "paid": 80.0,
                    "total_coverage": 80.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 80.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 100.0,
                    "paid": 39.0,
                    "total_coverage": 39.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 39.0,
                "remark_codes": [],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 61.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 62.0,
                    "paid": 42.0,
                    "total_coverage": 42.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 42.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:25Z"
}, {
    "event": "payment_report",
    "reference_id": "0",
    "id": "URBQROGW2EXXG",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "949.25",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08384-008001019",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***PH***MD",
            "npi": "973613564",
            "address": {
                "street_line_1": "*** W*** D",
                "street_line_2": null,
                "city": "SPARTA",
                "state": "NJ",
                "zip": "078712300"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "389104480"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "174016454"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**RIE",
            "last_name": "*****LER",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "**RIA",
            "last_name": "",
            "middle_name": "C",
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****HEN",
            "last_name": "****DIO",
            "middle_name": "J",
            "npi": "973613564"
        },
        "claim": {
            "control_number": "EV35RHVPX0000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 515.0,
                "paid": 0.0,
                "patient_responsibility": 0.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0812310-014-00003- D"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 07787"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2393",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2015-12-10",
                "service_end": "2015-12-10",
                "amount": {
                    "billed": 325.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "OA",
                    "type_label": "Other adjustments",
                    "reason_code": "18",
                    "reason_label": "Exact duplicate claim/service (Use only with Group Code OA except where state workers' compensation regulations requires CO)",
                    "amount": 325.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2391",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2015-12-10",
                "service_end": "2015-12-10",
                "amount": {
                    "billed": 190.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "OA",
                    "type_label": "Other adjustments",
                    "reason_code": "18",
                    "reason_label": "Exact duplicate claim/service (Use only with Group Code OA except where state workers' compensation regulations requires CO)",
                    "amount": 190.0,
                    "quantity": 1.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:25Z"
}, {
    "event": "payment_report",
    "reference_id": "0000865010029460P",
    "id": "URBQROJUVCCXV",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "949.25",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "08384-008001019",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***PH***MD",
            "npi": "973613564",
            "address": {
                "street_line_1": "*** W*** D",
                "street_line_2": null,
                "city": "SPARTA",
                "state": "NJ",
                "zip": "078712300"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "389104480"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "174016454"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*UDY",
            "last_name": "*****LLO",
            "middle_name": "",
            "id": "*******783"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****HEN",
            "last_name": "****DIO",
            "middle_name": "J",
            "npi": "973613564"
        },
        "claim": {
            "control_number": "EWPBRFD8M0000",
            "received_date": "2016-03-01",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 162.0,
                "paid": 122.0,
                "patient_responsibility": 0.0,
                "total_coverage": 162.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0812310-015-00003- D"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 07787"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 162.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1330",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 0.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 100.0,
                    "paid": 80.0,
                    "total_coverage": 80.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 80.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 62.0,
                    "paid": 42.0,
                    "total_coverage": 42.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 42.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:25Z"
}, {
    "event": "payment_report",
    "reference_id": "0",
    "id": "8JL9FOQJ648X2S",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "H",
            "type_label": "Notification Only",
            "total_payment_amount": "0",
            "credit": true,
            "debit": false,
            "payment_method_code": "NON",
            "payment_method_label": "Non-Payment Data",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "916068500002480",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ER***ER",
            "npi": "906912967",
            "address": {
                "street_line_1": "***0 ***36",
                "street_line_2": null,
                "city": "AVON",
                "state": "IN",
                "zip": "46123"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "575948450"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "110139852"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*ISA",
            "last_name": "******NER",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "*ISA",
            "last_name": "",
            "middle_name": "K",
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERT",
            "last_name": "****HER",
            "middle_name": "B",
            "npi": "949216877"
        },
        "claim": {
            "control_number": "E4Y0RF64N0000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 3391.0,
                "paid": 0.0,
                "patient_responsibility": 2502.0,
                "total_coverage": 3391.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0885954-015-00001-AB"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01858"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 3391.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D6752",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 1127.0,
                    "paid": 0.0,
                    "total_coverage": 839.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 839.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 288.0,
                    "quantity": 1.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 839.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D6752",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 1127.0,
                    "paid": 0.0,
                    "total_coverage": 839.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 839.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 288.0,
                    "quantity": 1.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 839.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D6242",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 1137.0,
                    "paid": 0.0,
                    "total_coverage": 824.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 824.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 313.0,
                    "quantity": 1.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 824.0,
                    "quantity": 1.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:25Z"
}, {
    "event": "payment_report",
    "reference_id": "SW37Q0ITN",
    "id": "32QDH5WVYGNWR",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "H",
            "type_label": "Notification Only",
            "total_payment_amount": "0",
            "credit": true,
            "debit": false,
            "payment_method_code": "NON",
            "payment_method_label": "Non-Payment Data",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "916068480000359",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***RN***A.",
            "npi": "989215020",
            "address": {
                "street_line_1": "***0 ***ST",
                "street_line_2": null,
                "city": "ORLANDO",
                "state": "FL",
                "zip": "328012116"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "224401870"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "142143859"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***HEL",
            "last_name": "***MAN",
            "middle_name": "",
            "id": "*******807"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****RGE",
            "last_name": "****ULO",
            "middle_name": "R",
            "npi": "989215020"
        },
        "claim": {
            "control_number": "E7JLRH1680000",
            "received_date": "2016-03-07",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": null,
            "status": ["predetermination"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 353.0,
                "paid": 0.0,
                "patient_responsibility": 157.8,
                "total_coverage": 353.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [{
                "type_code": "OA",
                "type_label": "Other adjustments",
                "reason_code": "101",
                "reason_label": "Predetermination: anticipated payment upon completion of services or claim adjudication.",
                "amount": 195.2,
                "quantity": 0.0
            }],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0657526-010-00003-FL"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01847"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 353.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2160",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "1900-01-01",
                "service_end": "1900-01-01",
                "amount": {
                    "billed": 128.0,
                    "paid": 43.2,
                    "total_coverage": 128.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 128.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "2",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 24.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "1",
                    "reason_label": "Deductible Amount",
                    "amount": 50.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 10.8,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2160",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "1900-01-01",
                "service_end": "1900-01-01",
                "amount": {
                    "billed": 128.0,
                    "paid": 83.2,
                    "total_coverage": 128.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 128.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "1",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 24.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 20.8,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2150",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "1900-01-01",
                "service_end": "1900-01-01",
                "amount": {
                    "billed": 97.0,
                    "paid": 68.8,
                    "total_coverage": 97.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 97.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "3",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 11.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 17.2,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:24Z"
}, {
    "event": "claim_received",
    "reference_id": "8JL5UGILNJD98E",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "payment_report",
    "reference_id": "0",
    "id": "8JL9FO6E4IWQ2J",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "H",
            "type_label": "Notification Only",
            "total_payment_amount": "0",
            "credit": true,
            "debit": false,
            "payment_method_code": "NON",
            "payment_method_label": "Non-Payment Data",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "916068460002047",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***N ***A.",
            "npi": "977011706",
            "address": {
                "street_line_1": "***1 ***VE",
                "street_line_2": null,
                "city": "N LITTLE ROCK",
                "state": "AR",
                "zip": "721168052"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "839766210"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "108571716"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "****ORY",
            "last_name": "***LER",
            "middle_name": "S",
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******761"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****OHN",
            "last_name": "****EAN",
            "middle_name": "H",
            "npi": "977011706"
        },
        "claim": {
            "control_number": "EFPBR7LKW0000",
            "received_date": "2016-02-29",
            "expiration_date": null,
            "filing_indicator_type": "13",
            "filing_indicator_label": "Point of Service (POS)",
            "place_of_service": "11",
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 700.0,
                "paid": 0.0,
                "patient_responsibility": 700.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0868154-013-00002- D"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Choice  POS II"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": null,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8886323862"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "99204",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-08",
                "service_end": "2016-02-08",
                "amount": {
                    "billed": 700.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N20"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 700.0,
                    "quantity": 1.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:23Z"
}, {
    "event": "payment_report",
    "reference_id": "SW37Q0ITA",
    "id": "8JL9FNV1AL5M5L",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "H",
            "type_label": "Notification Only",
            "total_payment_amount": "0",
            "credit": true,
            "debit": false,
            "payment_method_code": "NON",
            "payment_method_label": "Non-Payment Data",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "916068360000417",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***RN***A.",
            "npi": "989215020",
            "address": {
                "street_line_1": "***0 ***ST",
                "street_line_2": null,
                "city": "ORLANDO",
                "state": "FL",
                "zip": "328012116"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "224401870"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "142143859"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*IRK",
            "last_name": "**KER",
            "middle_name": "",
            "id": "*******526"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****RGE",
            "last_name": "****ULO",
            "middle_name": "R",
            "npi": "989215020"
        },
        "claim": {
            "control_number": "E7ABRGRC70000",
            "received_date": "2016-03-07",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": null,
            "status": ["predetermination"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 258.0,
                "paid": 0.0,
                "patient_responsibility": 103.2,
                "total_coverage": 258.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [{
                "type_code": "OA",
                "type_label": "Other adjustments",
                "reason_code": "101",
                "reason_label": "Predetermination: anticipated payment upon completion of services or claim adjudication.",
                "amount": 154.8,
                "quantity": 0.0
            }],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0360095-011-00001- K"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01847"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 258.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D9940",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "1900-01-01",
                "service_end": "1900-01-01",
                "amount": {
                    "billed": 258.0,
                    "paid": 154.8,
                    "total_coverage": 258.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 258.0,
                "remark_codes": [],
                "provider_control_number": "1",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 103.2,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:22Z"
}, {
    "event": "claim_rejected",
    "reference_id": "8JL5UGILNJD98E",
    "status": "rejected",
    "acknowledgements": [{
        "event": "claim_received",
        "reference_id": "8JL5UGILNJD98E",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_rejected",
        "reference_id": "8JL5UGILNJD98E",
        "details": {
            "submission_status": "rejected",
            "payer_control_number": null,
            "effective_date": "2016-03-09",
            "codes": {
                "category_code": "A8",
                "category_label": "Acknowledgement / Rejected for relational field in error.",
                "status_code": "562",
                "status_label": "Billing Provider's National Provider Identifier (NPI). Billing Provider's tax id."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8JL5UGILNJD98E",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL5UGILNJD98E",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_rejected",
    "reference_id": "8JL5UGILNJD98E",
    "details": {
        "submission_status": "rejected",
        "payer_control_number": null,
        "effective_date": "2016-03-09",
        "codes": {
            "category_code": "A8",
            "category_label": "Acknowledgement / Rejected for relational field in error.",
            "status_code": "562",
            "status_label": "Billing Provider's National Provider Identifier (NPI). Billing Provider's tax id."
        }
    }
}, {
    "event": "payment_report",
    "reference_id": "0000000000024480P",
    "id": "8JL9FNB31O93IW",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "90",
            "credit": true,
            "debit": false,
            "payment_method_code": "ACH",
            "payment_method_label": "Automated Clearing House (ACH)",
            "payment_format_code": "CCP",
            "payment_format_label": "Cash Concentration/Disbursement plus Addenda (CCD+) (ACH)",
            "payment_date": "2016-03-11",
            "payment_trace_number": "816067570002057",
            "sender": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "031100209",
                "account_number": "0000009108",
                "id": "1066033492",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "113010547",
                "account_type": "Demand Deposit",
                "account_number": "70246384"
            }
        },
        "payee": {
            "name": "***FE***SE",
            "npi": "993610605",
            "address": {
                "street_line_1": "*** E***00",
                "street_line_2": null,
                "city": "SAN ANTONIO",
                "state": "TX",
                "zip": "782098329"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "721029530"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "122572643"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "****LES",
            "last_name": "****ELL",
            "middle_name": "",
            "id": "*******712"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERY",
            "last_name": "****USE",
            "middle_name": "S",
            "npi": "993610605"
        },
        "claim": {
            "control_number": "EMJLR65V10000",
            "received_date": "2016-03-01",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 120.0,
                "paid": 90.0,
                "patient_responsibility": 30.0,
                "total_coverage": 120.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0882924-011-00000-DB"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Freedom of Choice"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 120.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1208",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 25.0,
                    "paid": 0.0,
                    "total_coverage": 25.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 25.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 25.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 95.0,
                    "paid": 90.0,
                    "total_coverage": 90.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 90.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 5.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:21Z"
}, {
    "event": "payment_report",
    "reference_id": "0000000000024499P",
    "id": "URBQRFRV5OKUC",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "547",
            "credit": true,
            "debit": false,
            "payment_method_code": "ACH",
            "payment_method_label": "Automated Clearing House (ACH)",
            "payment_format_code": "CCP",
            "payment_format_label": "Cash Concentration/Disbursement plus Addenda (CCD+) (ACH)",
            "payment_date": "2016-03-11",
            "payment_trace_number": "816067550002182",
            "sender": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "011900445",
                "account_number": "0000009046",
                "id": "1066033492",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "113010547",
                "account_type": "Demand Deposit",
                "account_number": "70246384"
            }
        },
        "payee": {
            "name": "***FE***SE",
            "npi": "993610605",
            "address": {
                "street_line_1": "*** E***00",
                "street_line_2": null,
                "city": "SAN ANTONIO",
                "state": "TX",
                "zip": "782098329"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "721029530"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "122572643"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***REY",
            "last_name": "***ICS",
            "middle_name": "P",
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERY",
            "last_name": "****USE",
            "middle_name": "S",
            "npi": "993610605"
        },
        "claim": {
            "control_number": "EYFBRD2MW0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 185.0,
                "paid": 185.0,
                "patient_responsibility": 0.0,
                "total_coverage": 185.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0657455-019-00016- F"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Dental PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 185.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1208",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 25.0,
                    "paid": 25.0,
                    "total_coverage": 25.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 25.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 95.0,
                    "paid": 95.0,
                    "total_coverage": 95.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 95.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 35.0,
                    "paid": 35.0,
                    "total_coverage": 35.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 35.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 30.0,
                    "paid": 30.0,
                    "total_coverage": 30.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 30.0,
                "remark_codes": [],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": []
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:18Z"
}, {
    "event": "payment_report",
    "reference_id": "0000000000024498P",
    "id": "8JL9FMCUDX50SQ",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "547",
            "credit": true,
            "debit": false,
            "payment_method_code": "ACH",
            "payment_method_label": "Automated Clearing House (ACH)",
            "payment_format_code": "CCP",
            "payment_format_label": "Cash Concentration/Disbursement plus Addenda (CCD+) (ACH)",
            "payment_date": "2016-03-11",
            "payment_trace_number": "816067550002182",
            "sender": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "011900445",
                "account_number": "0000009046",
                "id": "1066033492",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "113010547",
                "account_type": "Demand Deposit",
                "account_number": "70246384"
            }
        },
        "payee": {
            "name": "***FE***SE",
            "npi": "993610605",
            "address": {
                "street_line_1": "*** E***00",
                "street_line_2": null,
                "city": "SAN ANTONIO",
                "state": "TX",
                "zip": "782098329"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "721029530"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "122572643"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***ORA",
            "last_name": "****CKI",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERY",
            "last_name": "****USE",
            "middle_name": "S",
            "npi": "993610605"
        },
        "claim": {
            "control_number": "EXTWRD2MX0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 200.0,
                "paid": 175.0,
                "patient_responsibility": 25.0,
                "total_coverage": 200.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0657455-019-00016- F"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Dental PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 200.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1208",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 25.0,
                    "paid": 0.0,
                    "total_coverage": 25.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 25.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N129"
                }],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 25.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 95.0,
                    "paid": 95.0,
                    "total_coverage": 95.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 95.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 35.0,
                    "paid": 35.0,
                    "total_coverage": 35.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 35.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0220",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 15.0,
                    "paid": 15.0,
                    "total_coverage": 15.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 15.0,
                "remark_codes": [],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 30.0,
                    "paid": 30.0,
                    "total_coverage": 30.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 30.0,
                "remark_codes": [],
                "provider_control_number": "00000000005",
                "healthcare_policy": [],
                "adjustments": []
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:18Z"
}, {
    "event": "payment_report",
    "reference_id": "0000000000024496P",
    "id": "URBQRFLHWWUYQ",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "547",
            "credit": true,
            "debit": false,
            "payment_method_code": "ACH",
            "payment_method_label": "Automated Clearing House (ACH)",
            "payment_format_code": "CCP",
            "payment_format_label": "Cash Concentration/Disbursement plus Addenda (CCD+) (ACH)",
            "payment_date": "2016-03-11",
            "payment_trace_number": "816067550002182",
            "sender": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "011900445",
                "account_number": "0000009046",
                "id": "1066033492",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "01",
                "dfi_id_qualifier_label": "ABA Transit Routing Number Including Check Digits (9 digits)",
                "dfi_id": "113010547",
                "account_type": "Demand Deposit",
                "account_number": "70246384"
            }
        },
        "payee": {
            "name": "***FE***SE",
            "npi": "993610605",
            "address": {
                "street_line_1": "*** E***00",
                "street_line_2": null,
                "city": "SAN ANTONIO",
                "state": "TX",
                "zip": "782098329"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "721029530"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "122572643"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "******INE",
            "last_name": "****CKI",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERY",
            "last_name": "****USE",
            "middle_name": "S",
            "npi": "993610605"
        },
        "claim": {
            "control_number": "EXJLRD2MW0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 187.0,
                "paid": 187.0,
                "patient_responsibility": 0.0,
                "total_coverage": 187.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0657455-019-00016- F"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Dental PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 187.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 95.0,
                    "paid": 95.0,
                    "total_coverage": 95.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 95.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0277",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 62.0,
                    "paid": 62.0,
                    "total_coverage": 62.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 62.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 30.0,
                    "paid": 30.0,
                    "total_coverage": 30.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 30.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": []
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:18Z"
}, {
    "event": "payment_report",
    "reference_id": "0000000021173180P",
    "id": "URBQRF6Y09G8S",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "310",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024964325",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ER***ER",
            "npi": "906912967",
            "address": {
                "street_line_1": "***0 ***36",
                "street_line_2": null,
                "city": "AVON",
                "state": "IN",
                "zip": "46123"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "575948450"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "110139852"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***DEN",
            "last_name": "**ITE",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******676"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****AIG",
            "last_name": "****LER",
            "middle_name": "T",
            "npi": "906912967"
        },
        "claim": {
            "control_number": "ESPBRFYH50000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 179.0,
                "paid": 99.0,
                "patient_responsibility": 0.0,
                "total_coverage": 133.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0012000-010-00305- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01858"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 133.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8772773368"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1206",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 46.0,
                    "paid": 0.0,
                    "total_coverage": null,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": null,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 11.0,
                    "quantity": 1.0
                }, {
                    "type_code": "OA",
                    "type_label": "Other adjustments",
                    "reason_code": "18",
                    "reason_label": "Exact duplicate claim/service (Use only with Group Code OA except where state workers' compensation regulations requires CO)",
                    "amount": 35.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0272",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 47.0,
                    "paid": 35.0,
                    "total_coverage": 35.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 35.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 12.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0240",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 43.0,
                    "paid": 32.0,
                    "total_coverage": 32.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 32.0,
                "remark_codes": [],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 11.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0240",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 43.0,
                    "paid": 32.0,
                    "total_coverage": 32.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 32.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 11.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:18Z"
}, {
    "event": "payment_report",
    "reference_id": "0000000021173181P",
    "id": "8JL9FM8NMDXL0J",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "310",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024964325",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ER***ER",
            "npi": "906912967",
            "address": {
                "street_line_1": "***0 ***36",
                "street_line_2": null,
                "city": "AVON",
                "state": "IN",
                "zip": "46123"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "575948450"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "110139852"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**BER",
            "last_name": "**ITE",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******676"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****AIG",
            "last_name": "****LER",
            "middle_name": "T",
            "npi": "906912967"
        },
        "claim": {
            "control_number": "ESY0RG31F0000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 46.0,
                "paid": 0.0,
                "patient_responsibility": 35.0,
                "total_coverage": 46.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0012000-010-00305- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01858"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 46.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8772773368"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1206",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-23",
                "service_end": "2016-02-23",
                "amount": {
                    "billed": 46.0,
                    "paid": 0.0,
                    "total_coverage": 35.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 35.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 11.0,
                    "quantity": 1.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 35.0,
                    "quantity": 1.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:18Z"
}, {
    "event": "payment_report",
    "reference_id": "0000000021173336P",
    "id": "8JL9FM7349J6CP",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "310",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024964325",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ER***ER",
            "npi": "906912967",
            "address": {
                "street_line_1": "***0 ***36",
                "street_line_2": null,
                "city": "AVON",
                "state": "IN",
                "zip": "46123"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "575948450"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "110139852"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**NDI",
            "last_name": "******ONG",
            "middle_name": "",
            "id": "*******100"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERT",
            "last_name": "****HER",
            "middle_name": "B",
            "npi": "906912967"
        },
        "claim": {
            "control_number": "ET35RFNH70000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 249.0,
                "paid": 55.0,
                "patient_responsibility": 127.0,
                "total_coverage": 249.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0876241-038-00185-GH"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01858"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 249.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2392",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 249.0,
                    "paid": 55.0,
                    "total_coverage": 182.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 182.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 67.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "1",
                    "reason_label": "Deductible Amount",
                    "amount": 25.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "204",
                    "reason_label": "This service/equipment/drug is not covered under the patient\u2019s current benefit plan",
                    "amount": 102.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:18Z"
}, {
    "event": "payment_report",
    "reference_id": "636544006",
    "id": "8JL9FM4YI4AW6J",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1043",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024962699",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ES***JR",
            "npi": "978115382",
            "address": {
                "street_line_1": "***7 ***CE",
                "street_line_2": null,
                "city": "COVINGTON",
                "state": "LA",
                "zip": "704334955"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "828113800"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "102279920"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***ALD",
            "last_name": "****INE",
            "middle_name": "E",
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****NON",
            "last_name": "****YLE",
            "middle_name": "O",
            "npi": "978115382"
        },
        "claim": {
            "control_number": "EPY0R767W0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 1264.0,
                "paid": 612.0,
                "patient_responsibility": 497.0,
                "total_coverage": 1264.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0878774-013-00003-PA"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 03660"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 1264.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2160",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 298.0,
                    "paid": 65.6,
                    "total_coverage": 255.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 255.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 43.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 123.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "1",
                    "reason_label": "Deductible Amount",
                    "amount": 50.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 16.4,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2393",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 298.0,
                    "paid": 204.0,
                    "total_coverage": 255.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 255.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 43.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 51.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2392",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 242.0,
                    "paid": 170.4,
                    "total_coverage": 213.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 213.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 29.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 42.6,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2150",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 242.0,
                    "paid": 93.6,
                    "total_coverage": 213.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 213.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 29.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 96.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 23.4,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2140",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 184.0,
                    "paid": 78.4,
                    "total_coverage": 173.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 173.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000005",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 11.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "B8",
                    "reason_label": "Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 75.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 19.6,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:17Z"
}, {
    "event": "payment_report",
    "reference_id": "0000000021173207P",
    "id": "8JL9FM6AI49GFO",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "310",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024964325",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ER***ER",
            "npi": "906912967",
            "address": {
                "street_line_1": "***0 ***36",
                "street_line_2": null,
                "city": "AVON",
                "state": "IN",
                "zip": "46123"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "575948450"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "110139852"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "**NDI",
            "last_name": "******ONG",
            "middle_name": "",
            "id": "*******100"
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****ERT",
            "last_name": "****HER",
            "middle_name": "B",
            "npi": "906912967"
        },
        "claim": {
            "control_number": "ESY0RG3PD0000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 256.0,
                "paid": 156.0,
                "patient_responsibility": 22.0,
                "total_coverage": 256.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0876241-038-00185-GH"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01858"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 256.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 98.0,
                    "paid": 71.0,
                    "total_coverage": 71.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 71.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 27.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 69.0,
                    "paid": 31.25,
                    "total_coverage": 44.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 44.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 25.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "204",
                    "reason_label": "This service/equipment/drug is not covered under the patient\u2019s current benefit plan",
                    "amount": 12.75,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0220",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 33.0,
                    "paid": 13.75,
                    "total_coverage": 23.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 23.0,
                "remark_codes": [],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 10.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "204",
                    "reason_label": "This service/equipment/drug is not covered under the patient\u2019s current benefit plan",
                    "amount": 9.25,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-29",
                "service_end": "2016-02-29",
                "amount": {
                    "billed": 56.0,
                    "paid": 40.0,
                    "total_coverage": 40.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 40.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 16.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:18Z"
}, {
    "event": "payment_report",
    "reference_id": "636212576",
    "id": "8JL9FM20RJOK5Z",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1043",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024962699",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ES***JR",
            "npi": "978115382",
            "address": {
                "street_line_1": "***7 ***CE",
                "street_line_2": null,
                "city": "COVINGTON",
                "state": "LA",
                "zip": "704334955"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "828113800"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "102279920"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***ALD",
            "last_name": "****INE",
            "middle_name": "E",
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****NON",
            "last_name": "****YLE",
            "middle_name": "O",
            "npi": "978115382"
        },
        "claim": {
            "control_number": "ENY0R5ZR00000",
            "received_date": "2016-03-01",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 176.0,
                "paid": 81.0,
                "patient_responsibility": 34.0,
                "total_coverage": 176.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0878774-013-00003-PA"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 03660"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 176.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8004517715"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1206",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-26",
                "service_end": "2016-02-26",
                "amount": {
                    "billed": 34.0,
                    "paid": 0.0,
                    "total_coverage": 34.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 34.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 34.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-26",
                "service_end": "2016-02-26",
                "amount": {
                    "billed": 91.0,
                    "paid": 60.0,
                    "total_coverage": 60.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 60.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 31.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-26",
                "service_end": "2016-02-26",
                "amount": {
                    "billed": 51.0,
                    "paid": 21.0,
                    "total_coverage": 21.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 21.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 30.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:17Z"
}, {
    "event": "payment_report",
    "reference_id": "636544009",
    "id": "32QDH51RHDHTU",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1043",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024962699",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ES***JR",
            "npi": "978115382",
            "address": {
                "street_line_1": "***7 ***CE",
                "street_line_2": null,
                "city": "COVINGTON",
                "state": "LA",
                "zip": "704334955"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "828113800"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "102279920"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*AMA",
            "last_name": "***VER",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "",
            "last_name": "",
            "middle_name": "",
            "id": "*******024"
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****MES",
            "last_name": "****EAU",
            "middle_name": "A",
            "npi": "978115382"
        },
        "claim": {
            "control_number": "EPFBR8GRS0000",
            "received_date": "2016-03-03",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 243.0,
                "paid": 201.0,
                "patient_responsibility": 42.0,
                "total_coverage": 243.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0608656-052-00710- M"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 243.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8886323862"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1206",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 34.0,
                    "paid": 0.0,
                    "total_coverage": 34.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 1.0,
                    "paid": 0.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 34.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "96",
                    "reason_label": "Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.",
                    "amount": 34.0,
                    "quantity": 1.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 91.0,
                    "paid": 89.0,
                    "total_coverage": 89.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 89.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 2.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0274",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 67.0,
                    "paid": 62.0,
                    "total_coverage": 62.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 62.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000004",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 5.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 51.0,
                    "paid": 50.0,
                    "total_coverage": 50.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 50.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 1.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:17Z"
}, {
    "event": "payment_report",
    "reference_id": "636791025",
    "id": "32QDH51G1WUI4",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "1043",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024962699",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***ES***JR",
            "npi": "978115382",
            "address": {
                "street_line_1": "***7 ***CE",
                "street_line_2": null,
                "city": "COVINGTON",
                "state": "LA",
                "zip": "704334955"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "828113800"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "102279920"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "****ARY",
            "last_name": "*ENN",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": "*********ORY",
            "last_name": "",
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****MES",
            "last_name": "****EAU",
            "middle_name": "A",
            "npi": "978115382"
        },
        "claim": {
            "control_number": "EKJLR817J0000",
            "received_date": "2016-03-04",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 157.0,
                "paid": 149.0,
                "patient_responsibility": 8.0,
                "total_coverage": 157.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0608656-052-00610- M"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 157.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8886323862"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1206",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 34.0,
                    "paid": 34.0,
                    "total_coverage": 34.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 34.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": []
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D1120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 72.0,
                    "paid": 65.0,
                    "total_coverage": 65.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 65.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 7.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-02",
                "service_end": "2016-03-02",
                "amount": {
                    "billed": 51.0,
                    "paid": 50.0,
                    "total_coverage": 50.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 50.0,
                "remark_codes": [{
                    "type_code": "HE",
                    "type_label": "Claim Payment Remark Codes",
                    "value": "N130"
                }],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 1.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:17Z"
}, {
    "event": "payment_report",
    "reference_id": "0",
    "id": "8JL9FLYTPN919T",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "525.5",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024962082",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***AN***DS",
            "npi": "927012170",
            "address": {
                "street_line_1": "***BO***30",
                "street_line_2": null,
                "city": "VILONIA",
                "state": "AR",
                "zip": "721730130"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "589250300"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "109129103"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "***LIE",
            "last_name": "****NKS",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****IAN",
            "last_name": "****ANE",
            "middle_name": "",
            "npi": "927012170"
        },
        "claim": {
            "control_number": "E7JLRF6GM0000",
            "received_date": "2016-03-01",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": null,
            "frequency": null,
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 1000.0,
                "paid": 442.5,
                "patient_responsibility": 421.5,
                "total_coverage": 1000.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0012000-010-00654- A"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01920"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 1000.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8772773368"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D2950",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-01-25",
                "service_end": "2016-01-25",
                "amount": {
                    "billed": 165.0,
                    "paid": 72.5,
                    "total_coverage": 145.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 145.0,
                "remark_codes": [],
                "provider_control_number": "00000000003",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 20.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 72.5,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D2750",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-25",
                "service_end": "2016-02-25",
                "amount": {
                    "billed": 810.0,
                    "paid": 349.0,
                    "total_coverage": 698.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 698.0,
                "remark_codes": [],
                "provider_control_number": "00000000002",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 112.0,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 349.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0220",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-02-25",
                "service_end": "2016-02-25",
                "amount": {
                    "billed": 25.0,
                    "paid": 21.0,
                    "total_coverage": 21.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 21.0,
                "remark_codes": [],
                "provider_control_number": "00000000001",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 4.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:17Z"
}, {
    "event": "payment_report",
    "reference_id": "SW31Q2EGY",
    "id": "8JL9FLXPUJ8KMC",
    "details": {
        "effective_date": "2016-03-08",
        "payer": {
            "name": "AETNA",
            "id": null,
            "address": {
                "street_line_1": "151 FARMINGTON AVENUE",
                "street_line_2": null,
                "city": "HARTFORD",
                "state": "CT",
                "zip": "06156"
            },
            "contacts": [{
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "Provider Service",
                "details": []
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "I",
            "type_label": "Remittance Information Only",
            "total_payment_amount": "525.5",
            "credit": true,
            "debit": false,
            "payment_method_code": "CHK",
            "payment_method_label": "Check",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-08",
            "payment_trace_number": "09822-024962082",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "***AN***DS",
            "npi": "927012170",
            "address": {
                "street_line_1": "***BO***30",
                "street_line_2": null,
                "city": "VILONIA",
                "state": "AR",
                "zip": "721730130"
            },
            "additional_ids": [{
                "type_code": "PQ",
                "type_label": "Payee Identification",
                "value": "589250300"
            }, {
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "109129103"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "*USS",
            "last_name": "**ARP",
            "middle_name": null,
            "id": null
        },
        "corrected_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": {
            "first_name": "****IAN",
            "last_name": "****ANE",
            "middle_name": "",
            "npi": "927012170"
        },
        "claim": {
            "control_number": "ERFBR78RN0000",
            "received_date": "2016-03-02",
            "expiration_date": null,
            "filing_indicator_type": "12",
            "filing_indicator_label": "Preferred Provider Organization (PPO)",
            "place_of_service": "11",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 98.0,
                "paid": 83.0,
                "patient_responsibility": 0.0,
                "total_coverage": 98.0,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [{
                "type_code": "1L",
                "type_label": "Group or Policy Number",
                "value": "0000003-010-00144-DT"
            }, {
                "type_code": "CE",
                "type_label": "Class of Contract Code",
                "value": "Aetna Dental  PPO NET 01920"
            }],
            "rendering_provider_ids": [],
            "moa_codes": [],
            "allowed_amount": 98.0,
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8886323862"
                }]
            }],
            "service_lines": [{
                "procedure_qualifier": "AD",
                "procedure_code": "D1110",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 62.0,
                    "paid": 54.0,
                    "total_coverage": 54.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 54.0,
                "remark_codes": [],
                "provider_control_number": "2",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 8.0,
                    "quantity": 0.0
                }]
            }, {
                "procedure_qualifier": "AD",
                "procedure_code": "D0120",
                "procedure_modifiers": [],
                "revenue_code": "",
                "service_start": "2016-03-01",
                "service_end": "2016-03-01",
                "amount": {
                    "billed": 36.0,
                    "paid": 29.0,
                    "total_coverage": 29.0,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "allowed_amount": 29.0,
                "remark_codes": [],
                "provider_control_number": "1",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "CO",
                    "type_label": "Contractual Obligations",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 7.0,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-09T00:00:17Z"
}, {
    "details": {
        "id": 1065320229,
        "facility_name": "Robert L. Wilson DDS, P.A.",
        "provider_name": "Robert L. Wilson DDS, P.A.",
        "tax_id": "710829639",
        "address": "708 W. Quitman",
        "city": "Heber Springs",
        "state": "AR",
        "zip": "72543",
        "ptan": "",
        "npi": "929218018",
        "status": "submitted",
        "created_at": "2015-08-27T11:45:30+00:00",
        "updated_at": "2016-02-04T18:44:53+00:00",
        "reject_reasons": [],
        "received_pdf": {
            "name": "enrollment_pdf_165915100_(1).pdf",
            "created_at": "2016-02-04T18:44:53+00:00",
            "updated_at": "2016-02-04T18:44:53+00:00",
            "download_url": "https://gds.eligibleapi.com/v1.5/enrollment_npis/:enrollment_npi_id/received_pdf/download?api_key=YOUR_API_KEY",
            "notification_message": "For the enrollment you must complete the steps given on the pdf. Once you have completed all the steps, please sign the pdf and upload back to us."
        },
        "enrollment_insurance_company": {
            "name": "Blue Advantage of Arkansas | Blue Shield of Arkansas | Health Advantage of Arkansas | Blue Advantage of Arkansas (remits returned under ARMCR)",
            "payer_id": "ARBLS",
            "transaction_type": "837P"
        }
    },
    "event": "received_pdf"
}, {
    "details": {
        "id": 1061910981,
        "facility_name": "Robert L. Wilson DDS, P.A.",
        "provider_name": "Robert L. Wilson DDS, P.A.",
        "tax_id": "710829639",
        "address": "708 W. Quitman",
        "city": "Heber Springs",
        "state": "AR",
        "zip": "72543",
        "ptan": "",
        "npi": "983617959",
        "status": "submitted",
        "created_at": "2016-01-04T22:41:39+00:00",
        "updated_at": "2016-02-04T18:45:04+00:00",
        "reject_reasons": [],
        "received_pdf": {
            "name": "enrollment_pdf_165915100_(1).pdf",
            "created_at": "2016-02-04T18:45:04+00:00",
            "updated_at": "2016-02-04T18:45:04+00:00",
            "download_url": "https://gds.eligibleapi.com/v1.5/enrollment_npis/:enrollment_npi_id/received_pdf/download?api_key=YOUR_API_KEY",
            "notification_message": "For the enrollment you must complete the steps given on the pdf. Once you have completed all the steps, please sign the pdf and upload back to us."
        },
        "enrollment_insurance_company": {
            "name": "Blue Advantage of Arkansas | Blue Shield of Arkansas | Health Advantage of Arkansas | Blue Advantage of Arkansas (remits returned under ARMCR)",
            "payer_id": "ARBLS",
            "transaction_type": "837P"
        }
    },
    "event": "received_pdf"
}, {
    "details": {
        "id": 550773491,
        "facility_name": "",
        "provider_name": "Joseph Bussell",
        "tax_id": "710732976",
        "address": "6020 ranch dr, Ste. C6",
        "city": "Little Rock",
        "state": "AR",
        "zip": "72223",
        "ptan": "",
        "npi": "943619879",
        "status": "submitted",
        "created_at": "2015-11-10T18:55:39+00:00",
        "updated_at": "2016-02-04T18:46:37+00:00",
        "reject_reasons": [],
        "received_pdf": {
            "name": "enrollment_pdf_165915100_(1).pdf",
            "created_at": "2016-02-04T18:46:37+00:00",
            "updated_at": "2016-02-04T18:46:37+00:00",
            "download_url": "https://gds.eligibleapi.com/v1.5/enrollment_npis/:enrollment_npi_id/received_pdf/download?api_key=YOUR_API_KEY",
            "notification_message": "For the enrollment you must complete the steps given on the pdf. Once you have completed all the steps, please sign the pdf and upload back to us."
        },
        "enrollment_insurance_company": {
            "name": "Blue Advantage of Arkansas | Blue Shield of Arkansas | Health Advantage of Arkansas | Blue Advantage of Arkansas (remits returned under ARMCR)",
            "payer_id": "ARBLS",
            "transaction_type": "837P"
        }
    },
    "event": "received_pdf"
}, {
    "details": {
        "id": 406241618,
        "facility_name": "Test Practice2",
        "provider_name": "",
        "tax_id": "1111",
        "address": "123 Sleepy Hollow Lane1",
        "city": "St Petersburg",
        "state": "Florida",
        "zip": "33704",
        "ptan": "",
        "npi": "912112332",
        "status": "submitted",
        "created_at": "2015-04-03T06:26:45+00:00",
        "updated_at": "2015-07-21T11:44:42+00:00",
        "reject_reasons": [],
        "received_pdf": {
            "name": "BCARC_enroll.pdf",
            "created_at": "2015-07-21T11:44:42+00:00",
            "updated_at": "2015-07-21T11:44:42+00:00",
            "download_url": "https://gds.eligibleapi.com/v1.5/enrollment_npis/:enrollment_npi_id/received_pdf/download?api_key=YOUR_API_KEY",
            "notification_message": "You must complete this form online using the following link www.ediservices.net. Once there, please add transaction 270 and choose \"Eligible, Inc.\" as your clearinghouse. Clearinghouse = Eligible, Inc. \u2022 Trading Partner ID/Submitter ID = E6380."
        },
        "enrollment_insurance_company": {
            "name": "Blue Advantage of Arkansas | Blue Shield of Arkansas | Health Advantage of Arkansas | Blue Advantage of Arkansas (remits returned under ARMCR)",
            "payer_id": "ARBLS",
            "transaction_type": "270"
        }
    },
    "event": "received_pdf"
}, {
    "details": {
        "id": 309137335,
        "facility_name": "Hosking and Killian Dentistry PLLC",
        "provider_name": "Douglas Killian DDS",
        "tax_id": "270325415",
        "address": "7255 9 Mile Rd",
        "city": "Mecosta",
        "state": "MI",
        "zip": "49332",
        "ptan": "N/A",
        "npi": "936911707",
        "status": "submitted",
        "created_at": "2015-09-14T14:09:09+00:00",
        "updated_at": "2015-10-09T11:00:22+00:00",
        "reject_reasons": [],
        "received_pdf": {
            "name": "MIBLS.pdf",
            "created_at": "2015-10-09T11:00:22+00:00",
            "updated_at": "2015-10-09T11:00:22+00:00",
            "download_url": "https://gds.eligibleapi.com/v1.5/enrollment_npis/:enrollment_npi_id/received_pdf/download?api_key=YOUR_API_KEY",
            "notification_message": "For enrollment you must complete the steps given on the pdf. Once you have completed all the steps, please sign the pdf and upload back to us."
        },
        "enrollment_insurance_company": {
            "name": "Blue Shield of Michigan | Blue Cross Blue Shield of Michigan | Blue Cross of Michigan",
            "payer_id": "MIBLS",
            "transaction_type": "837P"
        }
    },
    "event": "received_pdf"
}, {
    "details": {
        "id": 302637228,
        "facility_name": "",
        "provider_name": "Kristian & Kaitlin Dietz DDS",
        "tax_id": "462792277",
        "address": "1603 Regional Airport Blvd",
        "city": "Bentonville",
        "state": "AR",
        "zip": "72712",
        "ptan": "",
        "npi": "901413555",
        "status": "submitted",
        "created_at": "2015-11-24T14:37:43+00:00",
        "updated_at": "2015-11-24T16:51:21+00:00",
        "reject_reasons": [],
        "received_pdf": {
            "name": "enrollment_pdf_302637228.pdf",
            "created_at": "2015-11-24T16:51:22+00:00",
            "updated_at": "2015-11-24T16:51:22+00:00",
            "download_url": "https://gds.eligibleapi.com/v1.5/enrollment_npis/:enrollment_npi_id/received_pdf/download?api_key=YOUR_API_KEY",
            "notification_message": "For the enrollment you must complete the steps given on the pdf. Once you have completed all the steps, please sign the pdf and upload back to us."
        },
        "enrollment_insurance_company": {
            "name": "Blue Advantage of Arkansas | Blue Shield of Arkansas | Health Advantage of Arkansas | Blue Advantage of Arkansas (remits returned under ARMCR)",
            "payer_id": "ARBLS",
            "transaction_type": "837P"
        }
    },
    "event": "received_pdf"
}, {
    "details": {
        "id": 2616843,
        "facility_name": "Pinney Family Dentistry",
        "provider_name": "Joe Pinney",
        "tax_id": "710624669",
        "address": "1421 Country Club Rd",
        "city": "Sherwood",
        "state": "AR",
        "zip": "72120",
        "ptan": "n/a",
        "npi": "983611403",
        "status": "submitted",
        "created_at": "2015-04-13T14:41:21+00:00",
        "updated_at": "2016-02-04T18:47:37+00:00",
        "reject_reasons": [],
        "received_pdf": {
            "name": "enrollment_pdf_165915100_(1).pdf",
            "created_at": "2016-02-04T18:47:37+00:00",
            "updated_at": "2016-02-04T18:47:37+00:00",
            "download_url": "https://gds.eligibleapi.com/v1.5/enrollment_npis/:enrollment_npi_id/received_pdf/download?api_key=YOUR_API_KEY",
            "notification_message": "For the enrollment you must complete the steps given on the pdf. Once you have completed all the steps, please sign the pdf and upload back to us."
        },
        "enrollment_insurance_company": {
            "name": "Blue Advantage of Arkansas | Blue Shield of Arkansas | Health Advantage of Arkansas | Blue Advantage of Arkansas (remits returned under ARMCR)",
            "payer_id": "ARBLS",
            "transaction_type": "837P"
        }
    },
    "event": "received_pdf"
}, {
    "acknowledgements": [{
        "effective_date": "2015-09-15",
        "status": "received",
        "message": "Accepted for processing.",
        "errors": []
    }, {
        "effective_date": "2015-09-15",
        "status": "accepted",
        "message": "Accepted for processing.",
        "errors": []
    }, {
        "effective_date": "2015-09-15",
        "status": "submitted",
        "message": "Submitted to Payer for processing",
        "errors": []
    }, {
        "effective_date": "2015-09-15",
        "status": "created",
        "message": null,
        "errors": []
    }],
    "payer_control_number": "CP15258000741716366",
    "reference_id": "AYHCKQV36TFE",
    "status": "accepted",
    "page": 1,
    "per_page": 30,
    "num_of_pages": 1,
    "total": 4
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "MDAHLT",
        "payer_name": "Moda",
        "transaction_type": "270",
        "status": "available",
        "details": "Payer is working fine.",
        "updated_at": "08-03-2016 22:59",
        "message": null
    }
}, {
    "event": "claim_submitted",
    "reference_id": "8JL5UGILNJD98E",
    "details": {
        "submission_status": "submitted",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "",
            "category_label": "",
            "status_code": "",
            "status_label": "Claim has been submitted to payer"
        }
    }
}, {
    "event": "claim_submitted",
    "reference_id": "8JL5UGILNJD98E",
    "status": "submitted",
    "acknowledgements": [{
        "event": "claim_submitted",
        "reference_id": "8JL5UGILNJD98E",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL5UGILNJD98E",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_submitted",
    "reference_id": "32QC629C3ZPJO",
    "details": {
        "submission_status": "submitted",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "",
            "category_label": "",
            "status_code": "",
            "status_label": "Claim has been submitted to payer"
        }
    }
}, {
    "event": "claim_submitted",
    "reference_id": "32QC629C3ZPJO",
    "status": "submitted",
    "acknowledgements": [{
        "event": "claim_submitted",
        "reference_id": "32QC629C3ZPJO",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "32QC629C3ZPJO",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "payer_status",
    "details": {
        "payer_id": "BCDCC",
        "payer_name": "Blue Cross Blue Shield of District of Columbia (CareFirst)",
        "transaction_type": "270",
        "status": "available",
        "details": "Payer is working fine.",
        "updated_at": "08-03-2016 22:17",
        "message": null
    }
}, {
    "event": "claim_submitted",
    "reference_id": "8JL7GQINVMV6H9",
    "details": {
        "submission_status": "submitted",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "",
            "category_label": "",
            "status_code": "",
            "status_label": "Claim has been submitted to payer"
        }
    }
}, {
    "event": "claim_submitted",
    "reference_id": "8JL7GQINVMV6H9",
    "status": "submitted",
    "acknowledgements": [{
        "event": "claim_submitted",
        "reference_id": "8JL7GQINVMV6H9",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL7GQINVMV6H9",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_accepted",
    "reference_id": "8JL63510NPBG5W",
    "details": {
        "submission_status": "accepted",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A2",
            "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_accepted",
    "reference_id": "8JL63510NPBG5W",
    "status": "accepted",
    "acknowledgements": [{
        "event": "claim_accepted",
        "reference_id": "8JL63510NPBG5W",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "8JL63510NPBG5W",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_received",
        "reference_id": "8JL63510NPBG5W",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8JL63510NPBG5W",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL63510NPBG5W",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_received",
    "reference_id": "8JL5T8SLIQR82M",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "19",
            "status_label": "Entity acknowledges receipt of claim/encounter."
        }
    }
}, {
    "event": "claim_received",
    "reference_id": "8JL63510NPBG5W",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_received",
    "reference_id": "8JL5T8SLIQR82M",
    "status": "received",
    "acknowledgements": [{
        "event": "claim_received",
        "reference_id": "8JL5T8SLIQR82M",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8JL5T8SLIQR82M",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL5T8SLIQR82M",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_received",
    "reference_id": "8JL5T8SLIQR82M",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_received",
    "reference_id": "8JL5PZ6O12KM9S",
    "status": "received",
    "acknowledgements": [{
        "event": "claim_received",
        "reference_id": "8JL5PZ6O12KM9S",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "8JL5PZ6O12KM9S",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "8JL5PZ6O12KM9S",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-03-08",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [],
    "payment_statuses": []
}, {
    "event": "claim_received",
    "reference_id": "8JL5PZ6O12KM9S",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}, {
    "event": "claim_denied",
    "reference_id": "UQG1SAUXOA9UB",
    "status": "denied",
    "acknowledgements": [{
        "event": "claim_received",
        "reference_id": "UQG1SAUXOA9UB",
        "details": {
            "submission_status": "received",
            "payer_control_number": null,
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "A1",
                "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
                "status_code": "20",
                "status_label": "Accepted for processing."
            }
        }
    }, {
        "event": "claim_accepted",
        "reference_id": "UQG1SAUXOA9UB",
        "details": {
            "submission_status": "accepted",
            "payer_control_number": "1800316055736676000",
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "A2",
                "category_label": "Acknowledgement/Acceptance into adjudication system-The claim/encounter has been accepted into the adjudication system.",
                "status_code": "20",
                "status_label": "Entity acknowledges receipt of claim/encounter. Note: This code requires use of an Entity Code."
            }
        }
    }, {
        "event": "claim_submitted",
        "reference_id": "UQG1SAUXOA9UB",
        "details": {
            "submission_status": "submitted",
            "payer_control_number": null,
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": "Claim has been submitted to payer"
            }
        }
    }, {
        "event": "claim_created",
        "reference_id": "UQG1SAUXOA9UB",
        "details": {
            "submission_status": "created",
            "payer_control_number": null,
            "effective_date": "2016-02-24",
            "codes": {
                "category_code": "",
                "category_label": "",
                "status_code": "",
                "status_label": ""
            }
        }
    }],
    "payment_reports": [{
        "event": "payment_report",
        "reference_id": "UQG1SAUXOA9UB",
        "id": "B2MVKE15A8PE",
        "details": {
            "effective_date": "2016-03-01",
            "payer": {
                "name": "CGS - DME MAC JURISDICTION C",
                "id": "DMERC",
                "address": {
                    "street_line_1": "P O BOX 20010",
                    "street_line_2": null,
                    "city": "NASHVILLE",
                    "state": "TN",
                    "zip": "372020010"
                },
                "contacts": [{
                    "department_code": "CX",
                    "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                    "name": "JC CUSTOMER SERVICE",
                    "details": [{
                        "type_code": "TE",
                        "type_label": "Telephone",
                        "value": "8662704909"
                    }, {
                        "type_code": "EM",
                        "type_label": "Electronic Mail",
                        "value": "URL WWW.CGSMEDICARE.COM"
                    }]
                }, {
                    "department_code": "BL",
                    "department_label": "Technical Department",
                    "name": "CEDI HELP DESK",
                    "details": [{
                        "type_code": "TE",
                        "type_label": "Telephone",
                        "value": "8663119184"
                    }]
                }],
                "crossover_payer": null,
                "corrected_priority_payer": null
            },
            "financials": {
                "type_code": "H",
                "type_label": "Notification Only",
                "total_payment_amount": "0",
                "credit": true,
                "debit": false,
                "payment_method_code": "NON",
                "payment_method_label": "Non-Payment Data",
                "payment_format_code": "",
                "payment_format_label": "",
                "payment_date": "2016-03-07",
                "payment_trace_number": "09160673231",
                "sender": {
                    "dfi_id_qualifier": "",
                    "dfi_id_qualifier_label": "",
                    "dfi_id": "",
                    "account_number": "",
                    "id": "",
                    "supplemental_code": ""
                },
                "receiver": {
                    "dfi_id_qualifier": "",
                    "dfi_id_qualifier_label": "",
                    "dfi_id": "",
                    "account_type": "",
                    "account_number": ""
                }
            },
            "payee": {
                "name": "*** R***KE",
                "npi": "971414089",
                "address": {
                    "street_line_1": "***03***AD",
                    "street_line_2": "BUILDING 4",
                    "city": "SAN ANTONIO",
                    "state": "TX",
                    "zip": "782305470"
                },
                "additional_ids": [{
                    "type_code": "TJ",
                    "type_label": "Federal Taxpayer's Identification Number",
                    "value": "126579545"
                }],
                "adjustments": [],
                "delivery_method": null
            },
            "patient": {
                "first_name": "****OND",
                "last_name": "********JR.",
                "middle_name": "",
                "id": "*******91T"
            },
            "corrected_patient": {
                "first_name": "****OND",
                "last_name": "****** JR",
                "middle_name": null,
                "id": null
            },
            "other_patient": {
                "first_name": null,
                "last_name": null,
                "middle_name": null,
                "id": null
            },
            "service_provider": null,
            "claim": {
                "control_number": "16055736676000",
                "received_date": "2016-02-24",
                "expiration_date": null,
                "filing_indicator_type": "MB",
                "filing_indicator_label": "Medicare Part B",
                "place_of_service": "12",
                "frequency": "1",
                "responsibility_sequence": "primary",
                "status": ["processed"],
                "drg_code": null,
                "drg_quantity": null,
                "amount": {
                    "billed": 4995.0,
                    "paid": 0.0,
                    "patient_responsibility": 4995.0,
                    "total_coverage": null,
                    "prompt_payment_discount": null,
                    "per_day_limit": null,
                    "patient_paid": null,
                    "revised_interest": null,
                    "negative_ledger_balance": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "adjustments": [],
                "quantity": {
                    "actual": {
                        "covered": null,
                        "co_insured": null,
                        "life_time_reserve": null
                    },
                    "estimated": {
                        "life_time_reserve": null,
                        "non_covered": null
                    },
                    "not_replaced_blood_unit": null,
                    "outlier_days": null,
                    "prescription": null,
                    "visits": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [],
                "rendering_provider_ids": [],
                "moa_codes": ["MA28"],
                "allowed_amount": null,
                "contacts": [],
                "service_lines": [{
                    "procedure_qualifier": "HC",
                    "procedure_code": "E0486",
                    "procedure_modifiers": ["NU", "KX"],
                    "revenue_code": "",
                    "service_start": "2015-08-11",
                    "service_end": "2015-08-11",
                    "amount": {
                        "billed": 4995.0,
                        "paid": 0.0,
                        "total_coverage": 1066.81,
                        "deduction": null,
                        "tax": null,
                        "total_claim_before_taxes": null,
                        "federal": {
                            "category_1": null,
                            "category_2": null,
                            "category_3": null,
                            "category_4": null,
                            "category_5": null
                        }
                    },
                    "quantity": {
                        "billed": 0.0,
                        "paid": 1.0,
                        "federal": {
                            "category_1": null,
                            "category_2": null,
                            "category_3": null,
                            "category_4": null,
                            "category_5": null
                        }
                    },
                    "additional_ids": [{
                        "type_code": "LU",
                        "type_label": "Location Number",
                        "value": "12"
                    }],
                    "rendering_provider_ids": [],
                    "allowed_amount": 1066.81,
                    "remark_codes": [],
                    "provider_control_number": "1",
                    "healthcare_policy": [],
                    "adjustments": [{
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "45",
                        "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                        "amount": 3928.19,
                        "quantity": 0.0
                    }, {
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "253",
                        "reason_label": "Sequestration - reduction in federal spending",
                        "amount": 17.07,
                        "quantity": 0.0
                    }, {
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "100",
                        "reason_label": "Payment made to patient/insured/responsible party/employer.",
                        "amount": 836.38,
                        "quantity": 0.0
                    }, {
                        "type_code": "PR",
                        "type_label": "Patient Responsibility",
                        "reason_code": "2",
                        "reason_label": "Coinsurance Amount",
                        "amount": 213.36,
                        "quantity": 0.0
                    }]
                }]
            }
        },
        "last_updated_at": "2016-03-08T22:00:30Z"
    }],
    "payment_statuses": []
}, {
    "event": "payment_report",
    "reference_id": "UQG1SAUXOA9UB",
    "id": "B2MVKE15A8PE",
    "details": {
        "effective_date": "2016-03-01",
        "payer": {
            "name": "CGS - DME MAC JURISDICTION C",
            "id": "DMERC",
            "address": {
                "street_line_1": "P O BOX 20010",
                "street_line_2": null,
                "city": "NASHVILLE",
                "state": "TN",
                "zip": "372020010"
            },
            "contacts": [{
                "department_code": "CX",
                "department_label": "Payers Claim Office. Location responsible for paying bills related to medical care received",
                "name": "JC CUSTOMER SERVICE",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8662704909"
                }, {
                    "type_code": "EM",
                    "type_label": "Electronic Mail",
                    "value": "URL WWW.CGSMEDICARE.COM"
                }]
            }, {
                "department_code": "BL",
                "department_label": "Technical Department",
                "name": "CEDI HELP DESK",
                "details": [{
                    "type_code": "TE",
                    "type_label": "Telephone",
                    "value": "8663119184"
                }]
            }],
            "crossover_payer": null,
            "corrected_priority_payer": null
        },
        "financials": {
            "type_code": "H",
            "type_label": "Notification Only",
            "total_payment_amount": "0",
            "credit": true,
            "debit": false,
            "payment_method_code": "NON",
            "payment_method_label": "Non-Payment Data",
            "payment_format_code": "",
            "payment_format_label": "",
            "payment_date": "2016-03-07",
            "payment_trace_number": "09160673231",
            "sender": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_number": "",
                "id": "",
                "supplemental_code": ""
            },
            "receiver": {
                "dfi_id_qualifier": "",
                "dfi_id_qualifier_label": "",
                "dfi_id": "",
                "account_type": "",
                "account_number": ""
            }
        },
        "payee": {
            "name": "*** R***KE",
            "npi": "971414089",
            "address": {
                "street_line_1": "***03***AD",
                "street_line_2": "BUILDING 4",
                "city": "SAN ANTONIO",
                "state": "TX",
                "zip": "782305470"
            },
            "additional_ids": [{
                "type_code": "TJ",
                "type_label": "Federal Taxpayer's Identification Number",
                "value": "126579545"
            }],
            "adjustments": [],
            "delivery_method": null
        },
        "patient": {
            "first_name": "****OND",
            "last_name": "********JR.",
            "middle_name": "",
            "id": "*******91T"
        },
        "corrected_patient": {
            "first_name": "****OND",
            "last_name": "****** JR",
            "middle_name": null,
            "id": null
        },
        "other_patient": {
            "first_name": null,
            "last_name": null,
            "middle_name": null,
            "id": null
        },
        "service_provider": null,
        "claim": {
            "control_number": "16055736676000",
            "received_date": "2016-02-24",
            "expiration_date": null,
            "filing_indicator_type": "MB",
            "filing_indicator_label": "Medicare Part B",
            "place_of_service": "12",
            "frequency": "1",
            "responsibility_sequence": "primary",
            "status": ["processed"],
            "drg_code": null,
            "drg_quantity": null,
            "amount": {
                "billed": 4995.0,
                "paid": 0.0,
                "patient_responsibility": 4995.0,
                "total_coverage": null,
                "prompt_payment_discount": null,
                "per_day_limit": null,
                "patient_paid": null,
                "revised_interest": null,
                "negative_ledger_balance": null,
                "tax": null,
                "total_claim_before_taxes": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "adjustments": [],
            "quantity": {
                "actual": {
                    "covered": null,
                    "co_insured": null,
                    "life_time_reserve": null
                },
                "estimated": {
                    "life_time_reserve": null,
                    "non_covered": null
                },
                "not_replaced_blood_unit": null,
                "outlier_days": null,
                "prescription": null,
                "visits": null,
                "federal": {
                    "category_1": null,
                    "category_2": null,
                    "category_3": null,
                    "category_4": null,
                    "category_5": null
                }
            },
            "additional_ids": [],
            "rendering_provider_ids": [],
            "moa_codes": ["MA28"],
            "allowed_amount": null,
            "contacts": [],
            "service_lines": [{
                "procedure_qualifier": "HC",
                "procedure_code": "E0486",
                "procedure_modifiers": ["NU", "KX"],
                "revenue_code": "",
                "service_start": "2015-08-11",
                "service_end": "2015-08-11",
                "amount": {
                    "billed": 4995.0,
                    "paid": 0.0,
                    "total_coverage": 1066.81,
                    "deduction": null,
                    "tax": null,
                    "total_claim_before_taxes": null,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "quantity": {
                    "billed": 0.0,
                    "paid": 1.0,
                    "federal": {
                        "category_1": null,
                        "category_2": null,
                        "category_3": null,
                        "category_4": null,
                        "category_5": null
                    }
                },
                "additional_ids": [{
                    "type_code": "LU",
                    "type_label": "Location Number",
                    "value": "12"
                }],
                "rendering_provider_ids": [],
                "allowed_amount": 1066.81,
                "remark_codes": [],
                "provider_control_number": "1",
                "healthcare_policy": [],
                "adjustments": [{
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "45",
                    "reason_label": "Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use only with Group Codes PR or CO depending upon liability)",
                    "amount": 3928.19,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "253",
                    "reason_label": "Sequestration - reduction in federal spending",
                    "amount": 17.07,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "100",
                    "reason_label": "Payment made to patient/insured/responsible party/employer.",
                    "amount": 836.38,
                    "quantity": 0.0
                }, {
                    "type_code": "PR",
                    "type_label": "Patient Responsibility",
                    "reason_code": "2",
                    "reason_label": "Coinsurance Amount",
                    "amount": 213.36,
                    "quantity": 0.0
                }]
            }]
        }
    },
    "last_updated_at": "2016-03-08T22:00:30Z"
}, {
    "event": "claim_received",
    "reference_id": "8JL53HGWV07ONA",
    "details": {
        "submission_status": "received",
        "payer_control_number": null,
        "effective_date": "2016-03-08",
        "codes": {
            "category_code": "A1",
            "category_label": "Acknowledgement/Receipt-The claim/encounter has been received. This does not mean that the claim has been accepted for adjudication.",
            "status_code": "20",
            "status_label": "Accepted for processing."
        }
    }
}]<?php

    return ob_get_clean();
}
