<?php

namespace Tests\\Feature;

use Tests\\TestCase;

class DashboardTest extends TestCase
{
    public function test_dashboard_loads_successfully(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_dashboard_displays_metrics(): void
    {
        $response = $this->get('/dashboard');
        $response->assertViewHas('total_products');
        $response->assertViewHas('total_suppliers');
        $response->assertViewHas('total_sales');
        $response->assertViewHas('monthly_revenue');
    }
}
