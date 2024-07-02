<?php

/**
 * E -> Job Total
 * L -> Technician Material
 * M -> Company Material
 * C16 -> Technician Percentage
 * C17 -> Company Percentage
 * I -> Cash
 * J -> Credit
 * K -> Check
 * N -> Profit to technician
 *
 * Profit to tech => (E - L -M) * C16 + L => ($jobTotal - $techMaterials + $companyMaterials) * $techPercentage + $techMaterialss
 * Balance to tech => If Cash, N - E - L =>  $techProfit - $jobTotal + $techMaterials,
 *                    If Credit OR Check, (E - N - L) * C16 + L => ($jobTotal - $companyMaterials - $techMaterial) * $techPercentage + $techMaterials
 */

namespace App\Services;

use App\Models\SubReport;

class SubReportCalculator
{
    public static SubReport $report;

    public static function technicianProfit(): int
    {
        return (static::$report->job_total - static::$report->technician_materials_cost -
                static::$report->company_materials_cost) * percentage(static::$report->technician_share_percentage) +
                static::$report->technician_materials_cost;
    }

    public static function technicianBalance(): int
    {
        return match (static::$report->payment_method) {
            'cash' => static::technicianBalanceOnCash(),
            default => static::technicianBalanceOnDefault(),
        };
    }

    public static function technicianBalanceOnCash(): int
    {
        return static::$report->technician_profit - static::$report->job_total +
               static::$report->technician_materials_cost;
    }

    public static function technicianBalanceOnDefault(): int
    {
        return (static::$report->job_total - static::$report->company_materials_cost -
                static::$report->technician_materials_cost) * percentage(static::$report->technician_share_percentage) +
                static::$report->technician_materials_cost;
    }

    public static function companyBalanceOnCash(): int
    {
        return (-1) * static::$report->technician_balance;
    }

    public static function companyBalanceOnDefault(): int
    {
        return static::$report->job_total - static::$report->technician_balance;
    }

    public static function companyBalance(): int
    {
        return match (static::$report->payment_method) {
            'cash' => static::companyBalanceOnCash(),
            default => static::companyBalanceOnDefault(),
        };
    }

    public static function calculate(SubReport $report): SubReport
    {
        static::$report = $report;

        if (present($report->job_total)) {
            $report->technician_profit = static::technicianProfit();
            $report->technician_balance = static::technicianBalance();
            $report->company_balance = static::companyBalance();
        }

        return $report;
    }
}
