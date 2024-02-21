<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    const LAND = 'Land';
    const SHIP = 'Ship';

    public function addons()
    {
        return $this->hasMany(BookingAddonDetails::class,'booking_id','id');
    }

    public function origin() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'origin_id', 'id');
    }

    public function destination() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_id', 'id');
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function payment()
    {
        return $this->hasOne(Payments::class, 'booking_id', 'id');
    }

    public static function scacList()
    {
        return [
            'ALRB' => 'AC Container Line - ALRB',
            'ADMU' => 'Admiral Container Lines - ADMU',
            'ALXP' => 'Aladin Express - ALXP',
            'ANRM' => 'Alianca - ANRM',
            'ALLF' => 'Allalouf Shipping Line - ALLF',
            'ALKU' => 'Altun Logistics - ALKU',
            'AMIG' => 'AMASS - AMIG',
            'APLU' => 'American President Lines (APL) - APLU',
            'ARKU' => 'Arkas - ARKU',
            'ASLU' => 'Asyad Line - ASLU',
            'ACLU' => 'Atlantic Container Line (ACL) - ACLU',
            'ANNU' => 'Australia National Line (ANL) - ANNU',
            'BLJU' => 'Avana Global FZCO (BALAJI) - BLJU',
            'BURU' => 'BAL Container Line - BURU',
            'BELC' => 'Bee Logistics Corp - BELC',
            'BLZU' => 'BLPL Singapore - BLZU',
            'BANQ' => 'Blue Anchor America Line - BANQ',
            'BWLU' => 'Blue Water Lines (BWL) - BWLU',
            'BWLE' => 'Blue World Line - BWLE',
            'BMSU' => 'BMC Line Shipping - BMSU',
            'BNLS' => 'BNSF Logistics - BNLS',
            'CAKU' => 'CAMELLIA LINE CO LTD - CAKU',
            'CPNU' => 'Cargo-Partner - CPNU',
            'MBFU' => 'Carpenters Shipping - MBFU',
            'CHVW' => 'China Navigation Company (Swire Shipping) - CHVW',
            'CULU' => 'China United Lines LTD (CULINES) - CULU',
            'CKLU' => 'CK Line - CKLU',
            'CMDU' => 'CMA CGM - CMDU',
            '11DX' => 'CNC (Cheng Lie Navigation) - 11DX',
            'CSHP' => 'Containerships - CSHP',
            'CSYU' => 'Cordelia Container Shipping Line - CSYU',
            'COSU' => 'COSCO / China Shipping Container Lines (CSCL) - COSU',
            'CRAU' => 'Cosiarma S.p.A. - CRAU',
            'MLCW' => 'Crane Worldwide Logistics - MLCW',
            'CAMN' => 'Crowley Maritime - CAMN',
            'CMCU' => 'Crowley Maritime - CMCU',
            'DTRA' => 'Dachser - DTRA',
            'DLTU' => 'Dalreftrans - DLTU',
            'DMCQ' => 'Damco - DMCQ',
            'SHKK' => 'DB Schenker - SHKK',
            'DAYU' => 'Deutsche Afrika-Linien (DAL) - DAYU',
            'DHC2' => 'DHL Global Forwarding - DHC2',
            'PCSL' => 'Dong Young Shipping - PCSL',
            '11PG' => 'Dongjin Shipping - 11PG',
            'DSVF' => 'DSV Ocean Transport - DSVF',
            'ECNU' => 'Econship - ECNU',
            'ECUW' => 'ECU Worldwide - ECUW',
            'EIMU' => 'Eimskip - EIMU',
            'ESPU' => 'Emirates Shipping Line - ESPU',
            'EMKU' => 'Emkay Lines - EMKU',
            'ESLU' => 'Ethiopian Shipping Line - ESLU',
            'EUKO' => 'Eukor - EUKO',
            'EGLV' => 'Evergreen - EGLV',
            'EXPO' => 'Expeditors (EIO) - EXPO',
            'FESO' => 'FESCO - FESO',
            'GSSW' => 'G2 Ocean - GSSW',
            'GSLU' => 'Gold Star Line - GSLU',
            'GRIU' => 'Grimaldi Deep Sea S.P.A. - GRIU',
            '12GE' => 'Hai Hua Shipping (HASCO) - 12GE',
            'SUDU' => 'Hamburg Sud - SUDU',
            'HLCU' => 'Hapag-Lloyd - HLCU',
            'HYSL' => 'Hecny Shipping Limited - HYSL',
            'HIFI' => 'Hellman Worldwise Logistics - HIFI',
            '11QU' => 'Heung-A Shipping - 11QU',
            'HGLU' => 'Hillebrand - HGLU',
            'HDMU' => 'Hyundai Merchant Marine (HMM) - HDMU',
            'LMCU' => 'Ignazio Messina - LMCU',
            'IILU' => 'Independent Container Line - IILU',
            'IDCL' => 'Indus Container Lines - IDCL',
            '12AT' => 'Interasia Lines - 12AT',
            'JASO' => 'JAS Worldwide (Ocean) - JASO',
            '11WJ' => 'Jin Jiang Shipping (SHJJ) - 11WJ',
            'KCDU' => 'Kalypso Compagnia Di Navigazione Spa - KCDU',
            'KKCL' => 'Kambara Kisen - KKCL',
            'KKLU' => 'Kawasaki Kisen Kaisha (K Line) - KKLU',
            'KWEO' => 'Kintetsu World Express - KWEO',
            'KMTU' => 'Korea Marine Transport (KMTC) - KMTU',
            'KHNN' => 'Kuehne + Nagel (KN) - KHNN',
            'LCUU' => 'Lancer Container Lines - LCUU',
            'LNLU' => 'Laurel Navigation - LNLU',
            'LEHO' => 'Leschaco - LEHO',
            'MCAW' => 'MacAndrews - MCAW',
            'MAEU' => 'Maersk - MAEU',
            'MAEI' => 'Maersk Line Limited (MLL) - MAEI',
            'MGSU' => 'Marguisa Shipping Lines - MGSU',
            'MEXU' => 'Mariana Express Lines (MELL) - MEXU',
            'MCSM' => 'Maritime Carrier Shipping (MACS) - MCSM',
            'MFTU' => 'Maritime Marfret - MFTU',
            'MATS' => 'Matson Navigation Company Inc (MATS) - MATS',
            'MXCU' => 'Maxicon Container Line (MCL) - MXCU',
            'MSCU' => 'Mediterranean Shipping Company (MSC) - MSCU',
            'MEDU' => 'Mediterranean Shipping Company (MSC) - MEDU',
            'MKLU' => 'Medkon Lines - MKLU',
            'MRTU' => 'Meratus Line - MRTU',
            '13CQ' => 'Minsheng Ocean Shipping - 13CQ',
            'MOLU' => 'Mitsui O.S.K. Lines - MOLU',
            'NSRU' => 'Namsung Shipping - NSRU',
            'NSHA' => 'National Shipping of America - NSHA',
            'NOKU' => 'Nauka Lines - NOKU',
            'PDLU' => 'Neptune Pacific Direct Line (NPDL) - PDLU',
            'NSTR' => 'NewStar - NSTR',
            'NIDU' => 'Nile Dutch Africa Line - NIDU',
            'NEDF' => 'Nippon Express - NEDF',
            'NPNE' => 'Nippon Express - NPNE',
            'NYKS' => 'Nippon Yusen Kaisha (NYK Line) - NYKS',
            '32GH' => 'Nirint Shipping - 32GH',
            'NSCL' => 'North Sea Container Line - NSCL',
            'ONEY' => 'Ocean Network Express (ONE) - ONEY',
            'OYLT' => 'Odyssey Logistics & Technology - OYLT',
            'OCLU' => 'Oman Container Lines - OCLU',
            'OOLU' => 'Orient Overseas Container Line (OOCL) - OOLU',
            'OSTI' => 'Orient Star - OSTI',
            'PCIU' => 'Pacific International Lines (PIL) - PCIU',
            'PALU' => 'Pan Asia Line - PALU',
            '15AC' => 'Pan Continental Shipping - 15AC',
            'POBU' => 'Pan Ocean - POBU',
            'PSHI' => 'Pasha Hawaii - PSHI',
            'PMLU' => 'Perma Shipping Line - PMLU',
            'PLLU' => 'Polynesia Line - PLLU',
            'PSL1' => 'PSL Navegacao - PSL1',
            'QNLU' => 'Qatar Navigation Lines (QNL) - QNLU',
            'REGU' => 'Regional Container Lines (RCL) - REGU',
            'RIFU' => 'Rif Line - RIFU',
            'ROMO' => 'Romocean - ROMO',
            'SRRP' => 'Route Planner - SRRP',
            'SAFM' => 'Safmarine - SAFM',
            'SPNU' => 'Salam Pacific Indonesia Lines (SPIL) - SPNU',
            'SIKU' => 'Samudera Shipping Line - SIKU',
            'SJKU' => 'Sarjak Container Lines - SJKU',
            'SHKU' => 'Sea Hawk Lines (SHAL) - SHKU',
            'MCCQ' => 'Sealand - MCCQ',
            'SEJJ' => 'Sealand - SEJJ',
            'SEAU' => 'Sealand - SEAU',
            'SJHH' => 'Sealead Shipping - SJHH',
            'SGNV' => 'Seatrade - SGNV',
            'SEIN' => 'Seino Logix Co - SEIN',
            'SSPH' => 'SETH Shipping - SSPH',
            'SHPT' => 'Shipco Transport - SHPT',
            'SCIU' => 'Shipping Corporation of India (SCI) - SCIU',
            'SKLU' => 'Sinokor - SKLU',
            '12IH' => 'Sinotrans Container Lines - 12IH',
            '12PD' => 'SITC Container Lines - 12PD',
            'SMLM' => 'SM Line Corporation (SML) - SMLM',
            'SNTU' => 'Stolt Tank Containers (STC) - SNTU',
            'BAXU' => 'Sunmarine Shipping Services - BAXU',
            '13DF' => 'T.S. Lines - 13DF',
            '32GG' => 'Taicang Container Lines - 32GG',
            'TSHG' => 'Tailwind Shipping Lines - TSHG',
            'GETU' => 'Tarros - GETU',
            'TOTE' => 'TOTE Maritime - TOTE',
            'TLXU' => 'Trans Asian Shipping Services - TLXU',
            'TJFH' => 'Transfar Shipping - TJFH',
            'TVSU' => 'Transvision Shipping Line - TVSU',
            'TSCW' => 'Tropical - TSCW',
            'TRKU' => 'Turkon - TRKU',
            'UWLD' => 'UWL - UWLD',
            'VGLT' => 'Vanguard Logistics - VGLT',
            'VMLU' => 'Vasco Maritime (VAS) - VMLU',
            'VASU' => 'VASI Shipping - VASU',
            'VCLU' => 'Volta Container Line - VCLU',
            'WECU' => 'W.E.C. (West European Container) Lines - WECU',
            'WLWH' => 'Wallenius Wilhelmsen - WLWH',
            '22AA' => 'Wan Hai - 22AA',
            'WHLC' => 'Wan Hai - WHLC',
            'WHLU' => 'Wan Hai - WHLU',
            'WWSU' => 'Westwood Shipping Lines - WWSU',
            'WTLU' => 'White Line Shipping - WTLU',
            'WDSB' => 'World Direct Shipping (WDS) - WDSB',
            'YMLU' => 'Yang Ming - YMLU',
            'YMPR' => 'Yang Ming - YMPR',
            'YMJA' => 'Yang Ming - YMJA',
            'YASV' => 'Yusen Logistics - YASV',
            'ZIMU' => 'ZIM - ZIMU',
        ];
    }
}
