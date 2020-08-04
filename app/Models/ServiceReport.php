<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ServiceReport extends AbstractUuidModel
{
    protected $fillable = [
        'order_confirmation_id',
        'shipping_address_id',
        'intent',
        'text',
        'test_run',
        'additional_work_required'
    ];

    protected static $testRuns = [
        'nicht durchgeführt', 'n.i.O', 'i.O.'
    ];

    const NO_TEST_RUN = 0;
    const TEST_RUN_NIO = 1;
    const TEST_RUN_IO = 2;

    public function testRun() {
        return static::$testRuns[$this->test_run];
    }

    public static function testRuns() {
        return static::$testRuns;
    }

    public function orderConfirmation() {
        return $this->belongsTo(OrderConfirmation::class, 'order_confirmation_id', 'id');
    }

    public function shippingAddress() {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id', 'id');
    }

    public function billingAddress() {
        return $this->salesProcess->customer->billingAddress();
    }

    public function salesProcess() {
        return $this->orderConfirmation->salesProcess();
    }

    public function technicians() {
        return $this->belongsToMany(Technician::class, 'service_report_technicians', 'service_report_id', 'technician_id')
            ->withPivot(['work_time', 'work_date']);
    }

    public function getLocalDate() {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d.m.Y');
    }

    public function getTotalWorktime() {
        $totalWorktime = 0;
        
        foreach ($this->technicians as $technician) {
            $totalWorktime += $technician->pivot->work_time;
        }

        return $totalWorktime;
    }


    /**
     * Component relationships
     */
    public function adsorbers() {
        return DB::table('adsorbers_service_reports')->where('service_report_id', '=', $this->id)
            ->join('adsorbers', 'adsorbers.id', '=', 'adsorbers_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'adsorbers.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'adsorbers_service_reports.scope_id')
            ->select([
                'adsorbers.id',
                'brands.name as brand',
                'adsorbers.model',
                'adsorbers.serial',
                'adsorbers.next_service',
                'service_scopes.description as scope'
            ])
            ->get();
    }

    public function adDryers() {
        return DB::table('ad_dryers_service_reports')->where('service_report_id', '=', $this->id)
            ->join('ad_dryers', 'ad_dryers.id', '=', 'ad_dryers_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'ad_dryers.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'ad_dryers_service_reports.scope_id')
            ->select([
                'ad_dryers.id',
                'brands.name as brand',
                'ad_dryers.model',
                'ad_dryers.serial',
                'ad_dryers.next_service',
                'service_scopes.description as scope'
            ])
            ->get();
    }

    public function compressors() {
        return DB::table('compressors_service_reports')->where('service_report_id', '=', $this->id)
            ->join('compressors', 'compressors.id', '=', 'compressors_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'compressors.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'compressors_service_reports.scope_id')
            ->select([
                'compressors.id',
                'brands.name as brand',
                'compressors.model',
                'compressors.serial',
                'compressors.next_service',
                'compressors_service_reports.hours_running',
                'compressors_service_reports.hours_loaded',
                'service_scopes.description as scope'
            ])
            ->get();
    }

    public function controllers() {
        return DB::table('controllers_service_reports')->where('service_report_id', '=', $this->id)
            ->join('controllers', 'controllers.id', '=', 'controllers_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'controllers.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'controllers_service_reports.scope_id')
            ->select([
                'controllers.id',
                'brands.name as brand',
                'controllers.model',
                'controllers.serial',
                'service_scopes.description as scope'
            ])
            ->get();
    }

    public function filters() {
        return DB::table('filters_service_reports')->where('service_report_id', '=', $this->id)
            ->join('filters', 'filters.id', '=', 'filters_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'filters.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'filters_service_reports.scope_id')
            ->select([
                'filters.id',
                'brands.name as brand',
                'filters.model',
                'filters.element',
                'filters.next_service',
                'service_scopes.description as scope'
            ])
            ->get();
    }

    public function receivers() {
        return DB::table('receivers_service_reports')->where('service_report_id', '=', $this->id)
            ->join('receivers', 'receivers.id', '=', 'receivers_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'receivers.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'receivers_service_reports.scope_id')
            ->select([
                'receivers.id',
                'brands.name as brand',
                'receivers.volume',
                'receivers.serial',
                'receivers.next_service',
                'service_scopes.description as scope'
            ])
            ->get();
    }

    public function refDryers() {
        return DB::table('ref_dryers_service_reports')->where('service_report_id', '=', $this->id)
            ->join('ref_dryers', 'ref_dryers.id', '=', 'ref_dryers_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'ref_dryers.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'ref_dryers_service_reports.scope_id')
            ->select([
                'ref_dryers.id',
                'brands.name as brand',
                'ref_dryers.model',
                'ref_dryers.serial',
                'ref_dryers.next_service',
                'service_scopes.description as scope'
            ])
            ->get();
    }
    
    public function sensors() {
        return DB::table('sensors_service_reports')->where('service_report_id', '=', $this->id)
            ->join('sensors', 'sensors.id', '=', 'sensors_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'sensors.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'sensors_service_reports.scope_id')
            ->select([
                'sensors.id',
                'brands.name as brand',
                'sensors.model',
                'sensors.serial',
                'service_scopes.description as scope'
            ])
            ->get();
    }

    public function separators() {
        return DB::table('separators_service_reports')->where('service_report_id', '=', $this->id)
            ->join('separators', 'separators.id', '=', 'separators_service_reports.component_id')
            ->join('brands', 'brands.id', '=', 'separators.brand_id')
            ->join('service_scopes', 'service_scopes.id', '=', 'separators_service_reports.scope_id')
            ->select([
                'separators.id',
                'brands.name as brand',
                'separators.model',
                'separators.next_service',
                'service_scopes.description as scope'
            ])
            ->get();
    }
}
