<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FinancialInstitution extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'parent_group',
        'intervention_country',
        'general_overview',
        'bank_scope_latest_accounts_date',
        'equity_usb',
        'assets_total_usd',
        'deposits_short_term_funding_usd',
        'net_income_usd',
        'loan_loss_reserve_gross_loans_percent',
        'total_capital_ratio_percent',
        'net_interest_margin_percent',
        'roaa_percent',
        'roae_percent',
        'cir_percent',
        'net_loans_total_assets_percent',
        'liquid_assets_funding_percent',
        'gross_loans_percent',
        'composite_rating',
        'country_rank_by_assets',
        'branches_number',
        'employees_number',
        'entity_type',
        'fi_grouping',
        'subsidiary_foreign_bank',
        'largest_shareholder',
        'government_majority_owner',
        'afdb_country_classification',
        'fragile_state',
        'afdb_country_risk_rating',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
