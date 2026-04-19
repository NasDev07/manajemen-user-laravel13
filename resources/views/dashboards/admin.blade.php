@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Dashboard</h4>
          <p class="text-muted mb-0">Welcome back! Here's system overview.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Cards Row -->
  <div class="row mb-4 g-3">
    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Profit</p>
              <h4 class="mb-0">$12,628</h4>
              <small class="text-success">
                <i class="bx bx-arrow-up"></i> +72.80%
              </small>
            </div>
            <div class="avatar rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-trending-up text-success" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Sales</p>
              <h4 class="mb-0">$4,679</h4>
              <small class="text-success">
                <i class="bx bx-arrow-up"></i> +28.42%
              </small>
            </div>
            <div class="avatar rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-shopping-bag text-info" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Payments</p>
              <h4 class="mb-0">$2,456</h4>
              <small class="text-danger">
                <i class="bx bx-arrow-down"></i> -14.82%
              </small>
            </div>
            <div class="avatar rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-credit-card text-danger" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Transactions</p>
              <h4 class="mb-0">$14,857</h4>
              <small class="text-success">
                <i class="bx bx-arrow-up"></i> +28.14%
              </small>
            </div>
            <div class="avatar rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-transfer-alt text-warning" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="row mb-4 g-3">
    <!-- Total Revenue Chart -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
          <h6 class="mb-0 fw-bold">Total Revenue</h6>
          <div>
            <button class="btn btn-sm btn-light">2025</button>
            <button class="btn btn-sm btn-light">2024</button>
          </div>
        </div>
        <div class="card-body">
          <div style="height: 300px;">
            <canvas id="revenueChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Growth Donut Chart -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Growth</h6>
        </div>
        <div class="card-body text-center">
          <div style="height: 250px; display: flex; justify-content: center; align-items: center;">
            <canvas id="growthChart" style="max-width: 250px; max-height: 250px;"></canvas>
          </div>
          <p class="text-muted mb-0 mt-3">
            <small>78% Growth | 62% Company Growth</small>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Row -->
  <div class="row g-3">
    <!-- Order Statistics -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Order Statistics</h6>
          <small class="text-muted">42.82k Total Sales</small>
        </div>
        <div class="card-body">
          <div class="text-center mb-3">
            <h4 class="mb-1">8,258</h4>
            <p class="text-muted small mb-0">Total Orders</p>
          </div>
          <div style="height: 250px;">
            <canvas id="ordersChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Profile Report -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Profile Report</h6>
          <span class="badge bg-warning text-dark">YEAR 2022</span>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <h5 class="mb-1">$84,686k</h5>
            <small class="text-success">
              <i class="bx bx-arrow-up"></i> +68.2%
            </small>
          </div>
          <div style="height: 200px;">
            <canvas id="profileChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Transactions -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-bold">Transactions</h6>
          <i class="bx bx-dots-vertical-rounded cursor-pointer"></i>
        </div>
        <div class="card-body">
          <div class="transaction-list">
            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
              <div class="avatar rounded-circle bg-danger bg-opacity-10 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bx bx-brand-paypal text-danger"></i>
              </div>
              <div class="flex-grow-1">
                <p class="mb-0 fw-medium">Paypal</p>
                <small class="text-muted">Send money</small>
              </div>
              <div class="text-end">
                <p class="mb-0 text-danger">-$250</p>
              </div>
            </div>

            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
              <div class="avatar rounded-circle bg-primary bg-opacity-10 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bx bx-wallet text-primary"></i>
              </div>
              <div class="flex-grow-1">
                <p class="mb-0 fw-medium">Wallet</p>
                <small class="text-muted">Bill payment</small>
              </div>
              <div class="text-end">
                <p class="mb-0 text-success">+$350</p>
              </div>
            </div>

            <div class="d-flex align-items-center">
              <div class="avatar rounded-circle bg-success bg-opacity-10 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bx bx-credit-card text-success"></i>
              </div>
              <div class="flex-grow-1">
                <p class="mb-0 fw-medium">Visa Card</p>
                <small class="text-muted">Debit card</small>
              </div>
              <div class="text-end">
                <p class="mb-0 text-danger">-$1200</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Revenue Chart
  const revenueCtx = document.getElementById('revenueChart').getContext('2d');
  new Chart(revenueCtx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
      datasets: [
        {
          label: '2025',
          data: [15, 5, 10, 25, 15, 10, 15],
          backgroundColor: '#004aff',
          borderRadius: 5,
          barThickness: 10
        },
        {
          label: '2024',
          data: [-10, -5, -15, -5, -10, -15, -5],
          backgroundColor: '#00d4ff',
          borderRadius: 5,
          barThickness: 10
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      indexAxis: 'x',
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Growth Donut Chart
  const growthCtx = document.getElementById('growthChart').getContext('2d');
  new Chart(growthCtx, {
    type: 'doughnut',
    data: {
      labels: ['Growth', 'Other'],
      datasets: [{
        data: [78, 22],
        backgroundColor: ['#a29bfe', '#f3f4f6'],
        borderColor: 'white',
        borderWidth: 3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });

  // Orders Chart (Pie)
  const ordersCtx = document.getElementById('ordersChart').getContext('2d');
  new Chart(ordersCtx, {
    type: 'doughnut',
    data: {
      labels: ['Completed', 'Pending', 'Cancelled'],
      datasets: [{
        data: [38, 45, 17],
        backgroundColor: ['#00d4ff', '#74c0fc', '#bfdbfe'],
        borderColor: 'white',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });

  // Profile Line Chart
  const profileCtx = document.getElementById('profileChart').getContext('2d');
  new Chart(profileCtx, {
    type: 'line',
    data: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [{
        label: 'Revenue',
        data: [30, 40, 35, 50, 45, 60, 55],
        borderColor: '#ff9f43',
        backgroundColor: 'rgba(255, 159, 67, 0.1)',
        borderWidth: 3,
        fill: true,
        pointRadius: 4,
        pointBackgroundColor: '#ff9f43'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
});
</script>
@endsection
