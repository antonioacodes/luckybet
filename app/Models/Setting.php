<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
  	public $timestamps = false;
  
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'software_name',
        'software_description',
        'software_notification',

        /// logos e background
        'software_favicon',
        'software_logo_white',
        'software_logo_black',
        'software_logo_black2',
        'software_background',
		'fb_api_token',
		'fb_pixel_token',
		'api_cpf_token',
      	
        'currency_code',
        'decimal_format',
        'currency_position',
        'prefix',
        'storage',
        'min_deposit',
        'max_deposit',
        'min_withdrawal',
        'max_withdrawal',

        /// vip
        'bonus_vip',
        'activate_vip_bonus',
      
      	//Bonus
      	'bonus_is_enable',
        'free_rounds_enabled',

        // Percent
        'ngr_percent',
        'revshare_percentage',
        'revshare_reverse',
        'cpa_value',
        'cpa_baseline',

        /// soccer
        'soccer_percentage',
        'turn_on_football',

        'initial_bonus',

        'suitpay_is_enable',
        'stripe_is_enable',
        'bspay_is_enable',
        'mercadopago_is_enable',
        'sharkpay_is_enable',
        'digitopay_is_enable',
      	'wazerpay_is_enable',

        /// withdrawal limit
        'withdrawal_limit',
        'withdrawal_period',

        'disable_spin',


        /// sub afiliado
        'perc_sub_lv1',
        'perc_sub_lv2',
        'perc_sub_lv3',

        /// campos do rollover
        'rollover',
        'rollover_deposit',
        'disable_rollover',
        'rollover_protection',

		'topbar_text',
      
        'default_gateway',
      	'cashback_enabled',

        // CAMPOS CORRETOS DO WHITELABEL
        'whitelabel_enabled',
        'whitelabel_next_payment_at',
        'whitelabel_token',
        'whitelabel_grace_days',
        'whitelabel_last_token_confirmed_at',
    ];

    protected $casts = [
        'whitelabel_enabled'                 => 'boolean',
        'whitelabel_next_payment_at'         => 'datetime',
        'whitelabel_last_token_confirmed_at' => 'datetime',
    ];
    
    protected $hidden = array('updated_at');
}
