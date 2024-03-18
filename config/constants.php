<?php

// User Types
const USER_TYPE_ADMIN = 1;
const USER_TYPE_CLIENT = 2;
const USER_TYPE_SHIPPING_COMPANY = 3;

// Statuses
const STATUS_DISABLED = 0;
const STATUS_ENABLED = 1;

// // Routes
const ROUTE_TYPE_SEA = 1;
const ROUTE_TYPE_LAND = 2;
const ROUTE_TYPE_AIR = 3;

return [
    'IGNORED_COMPANIES' => [
        env('MAERSK_COMPANY_ID'),
        env('CMA_COMPANY_ID'),
        env('HAPAG_COMPANY_ID'),
        env('MSC_COMPANY_ID')
    ],

    'MAERSK_COMPANY_ID' => env('MAERSK_COMPANY_ID'),

    'BOOKING_STATUS_IN_PROGRESS' => 1,
    'BOOKING_STATUS_COMPLETED' => 2,
    'BOOKING_STATUS_ON_HOLD' => 3,
    'BOOKING_STATUS_CANCELLED' => 4,
    
    'BOOKING_STATUS_CONFIRMED' => 5,
    'BOOKING_STATUS_SI_SUBMITTED' => 6,
    'BOOKING_STATUS_SI_CONFIRMED' => 7,
    'BOOKING_STATUS_EVGM_SUBMITTED' => 8,
    'BOOKING_STATUS_EVGM_CONFIRMED' => 9,
    'BOOKING_STATUS_DRAFT_BL_RECEIVED' => 10,
    'BOOKING_STATUS_DRAFT_BL_CONFIRMED' => 11,
    'BOOKING_STATUS_FINISHED' => 12,

    'WORK_WITH_US_FORM_STATUS_PENDING' => 1,
    'WORK_WITH_US_FORM_STATUS_ACCEPTED' => 2,
    'WORK_WITH_US_FORM_STATUS_REJECTED' => 3,


    //addons active/inactive status
    'ADDON_BOOKING_STATUS_INACTIVE' => 0,
    'ADDON_BOOKING_STATUS_ACTIVE' => 1,


    //Booking payment status
    'BOOKING_PAYMENT_STATUS_ON_HOLD' => 1,

    'BOOKING_PAYMENT_SUCCESS' => 'completed',
    'BOOKING_PAYMENT_PENDING' => 'progress',
    'BOOKING_PAYMENT_FAILED' => 'cancel',

    'ALLOWED_DOCUMENT_TYPES' => ['pdf, doc, docx, xls, xlsx'],

     // Company docs type
    'COMPANY_DOCUMENTS' =>[
                    (object) [ 'value' => 1, 'label' => 'Shipping License'],
                    (object) [ 'value' => 2, 'label' => 'VAT Certificate'],
    ],

    // Company registration status
    'COMPANY_REGISTRATION_STATUS_PENDING' => 1,
    'COMPANY_REGISTRATION_STATUS_APPROVED' => 2,
    'COMPANY_REGISTRATION_STATUS_RESUBMIT' => 3,
    'COMPANY_REGISTRATION_STATUS_REJECTED' => 4,
	'COMPANY_REGISTRATION_STATUS_INACTIVE' => 5,
	'COMPANY_REGISTRATION_STATUS_TERMINATED' => 6,

    'COMPANY_STATUSES' => [
        'COMPANY_REGISTRATION_STATUS_PENDING' => [
            'value' => 1,
            'label' => 'PENDING',
        ],
        'COMPANY_REGISTRATION_STATUS_APPROVED' => [
            'value' => 2,
            'label' => 'APPROVED',
        ],
        'COMPANY_REGISTRATION_STATUS_RESUBMIT' => [
            'value' => 3,
            'label' => 'RESUBMIT',
        ],
        'COMPANY_REGISTRATION_STATUS_REJECTED' => [
            'value' => 4,
            'label' => 'REJECTED',
        ],
		'COMPANY_REGISTRATION_STATUS_INACTIVE' => [
            'value' => 5,
            'label' => 'INACTIVE',
        ],
		'COMPANY_REGISTRATION_STATUS_TERMINATED' => [
            'value' => 6,
            'label' => 'TERMINATED',
        ]
    ],


    //user role
    'USER_TYPE_SUPERADMIN' => 1,
    'USER_TYPE_CUSTOMER' => 2,
    'USER_TYPE_EMPLOYEE' => 3,
    'USER_TYPE_SUPPLIER' => 4,
    'USER_TYPE_SHIPPER' => 5,
	
	//user statuses
    'USER_STATUS_ACTIVE' => 1,
    'USER_STATUS_INACTIVE' => 2,

    'COMPANY_BUSINESS_TYPE' => [
        (object) ['value' => 'insurance', 'label' => 'Insurance'],
        (object) ['value' => 'preshipment-inspection', 'label' => 'Pre Shipment Inspection Service'],
        (object) ['value' => 'clearance-agent', 'label' => 'Clearance Agent'],
        (object) ['value' => 'sea-transport', 'label' => 'Sea Transporter'],
        (object) ['value' => 'land-transport', 'label' => 'Land Transporter'],
        (object) ['value' => 'air-transport', 'label' => 'Air Transporter'],
    ],
   
    'EMPLOYEE_POSITIONS' => [
        (object) ['value' => 'Customer Service Coordinator', 'label' => 'Customer Service Coordinator'],
        (object) ['value' => 'Finance Coordinator', 'label' => 'Finance Coordinator'],
        (object) ['value' => 'Matter Expert', 'label' => 'Matter Expert'],
    ],
];
