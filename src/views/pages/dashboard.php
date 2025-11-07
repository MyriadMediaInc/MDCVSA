      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <!--  Row 1 -->
          <div class="row">
            <div class="col-lg-8 d-flex align-items-strech">
              <div class="card w-100">
                <div class="card-body">
                  <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                      <h5 class="card-title fw-semibold">Sales Profit</h5>
                    </div>
                    <div>
                      <select class="form-select">
                        <option value="1">March 2025</option>
                        <option value="2">April 2025</option>
                        <option value="3">May 2025</option>
                        <option value="4">June 2025</option>
                      </select>
                    </div>
                  </div>
                  <div id="sales-profit"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card bg-danger-subtle shadow-none w-100">
                    <div class="card-body">
                      <div class="d-flex mb-10 pb-1 justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-6">
                          <div
                            class="rounded-circle-shape bg-danger px-3 py-2 rounded-pill d-inline-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:users-group-rounded-bold-duotone"
                              class="fs-7 text-white"></iconify-icon>
                          </div>
                          <h6 class="mb-0 fs-4 fw-medium text-muted">
                            Total followers
                          </h6>
                        </div>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"><i
                                  class="fs-4 ti ti-plus"></i>Add</a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"><i
                                  class="fs-4 ti ti-edit"></i>Edit</a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"><i
                                  class="fs-4 ti ti-trash"></i>Delete</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="row align-items-end justify-content-between">
                        <div class="col-5">
                          <h2 class="mb-6 fs-8">4,562</h2>
                          <span class="badge rounded-pill border border-muted fw-bold text-muted fs-2 py-1">+23% last
                            month</span>
                        </div>
                        <div class="col-5">
                          <div id="total-followers" class="rounded-bars"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="card bg-secondary-subtle shadow-none w-100">
                    <div class="card-body">
                      <div class="d-flex mb-10 pb-1 justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-6">
                          <div
                            class="rounded-circle-shape bg-secondary px-3 py-2 rounded-pill d-inline-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:wallet-2-line-duotone" class="fs-7 text-white"></iconify-icon>
                          </div>
                          <h6 class="mb-0 fs-4 fw-medium text-muted">
                            Total Income
                          </h6>
                        </div>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"><i
                                  class="fs-4 ti ti-plus"></i>Add</a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"><i
                                  class="fs-4 ti ti-edit"></i>Edit</a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"><i
                                  class="fs-4 ti ti-trash"></i>Delete</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="row align-items-center justify-content-between pt-4">
                        <div class="col-5">
                          <h2 class="mb-6 fs-8 text-nowrap">$6,280</h2>
                          <span class="badge rounded-pill border border-muted fw-bold text-muted fs-2 py-1">+18% last
                            month</span>
                        </div>
                        <div class="col-5">
                          <div id="total-income"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>