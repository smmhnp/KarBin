@extends('base.BaseFormat')
@section('content')

    <div class="container">

        <h2><i class="fas fa-stream"></i>تابلوی جریان کار</h2>
        <div class="card">
            <div class="dashboard-filters">
                <div class="search-filter input-group input-group-sm">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="search" class="form-control form-control-sm" placeholder="جستجو در وظایف..." id="workflow-search">
                </div>
                
                <!-- اولویت Filter -->
                <div class="filter-item">
                <button class="btn btn-sm btn-outline-secondary btn-filter" data-filter="priority" id="workflowPriorityFilterBtn">
                    اولویت: همه <i class="fas fa-chevron-down"></i>
                    <span class="filtered-indicator"></span>
                </button>
                <div class="filter-dropdown" id="workflowPriorityFilterDropdown">
                    <div class="filter-dropdown-header">
                        <span class="filter-dropdown-title">فیلتر بر اساس اولویت</span>
                        <button class="filter-dropdown-close" title="بستن"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="filter-dropdown-body">
                        <div class="filter-dropdown-item active" data-value="all">همه</div>
                        <div class="filter-dropdown-item" data-value="high">بالا</div>
                        <div class="filter-dropdown-item" data-value="medium">متوسط</div>
                        <div class="filter-dropdown-item" data-value="low">پایین</div>
                    </div>
                </div>
                </div>
                
                <!-- پروژه Filter -->
                <div class="filter-item">
                <button class="btn btn-sm btn-outline-secondary btn-filter" data-filter="project" id="workflowProjectFilterBtn">
                    پروژه: همه <i class="fas fa-chevron-down"></i>
                    <span class="filtered-indicator"></span>
                </button>
                <div class="filter-dropdown" id="workflowProjectFilterDropdown">
                    <div class="filter-dropdown-header">
                        <span class="filter-dropdown-title">فیلتر بر اساس پروژه</span>
                        <button class="filter-dropdown-close" title="بستن"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="filter-dropdown-body">
                        <div class="filter-dropdown-item active" data-value="all">همه</div>
                        <div class="filter-dropdown-item" data-value="alpha">پروژه آلفا</div>
                        <div class="filter-dropdown-item" data-value="beta">پروژه بتا</div>
                    </div>
                </div>
                </div>
                
                <!-- مسئول Filter -->
                <div class="filter-item">
                <button class="btn btn-sm btn-outline-secondary btn-filter" data-filter="assignee" id="workflowAssigneeFilterBtn">
                    مسئول: همه <i class="fas fa-chevron-down"></i>
                    <span class="filtered-indicator"></span>
                </button>
                <div class="filter-dropdown" id="workflowAssigneeFilterDropdown">
                    <div class="filter-dropdown-header">
                        <span class="filter-dropdown-title">فیلتر بر اساس مسئول</span>
                        <button class="filter-dropdown-close" title="بستن"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="filter-dropdown-body">
                        <div class="filter-dropdown-item active" data-value="all">همه</div>
                        <div class="filter-dropdown-item" data-value="Lead">Lead</div>
                        <div class="filter-dropdown-item" data-value="DevLead">DevLead</div>
                        <div class="filter-dropdown-item" data-value="Nass">Nass</div>
                        <div class="filter-dropdown-item" data-value="Zara">Zara</div>
                    </div>
                </div>
                </div>
            </div>

            @php
                $todo = 0;
                $progress = 0;
                $review = 0;
                $done = 0;
            @endphp

             @foreach ($tasks as $item)
                @foreach ($item -> tasks as $task)
                    @php
                        $status = $task->status;
                        switch ($status) {
                            case 'برای انجام':
                                $todo++;
                                break;
                            case 'در حال انجام':
                                $progress++;
                                break;
                            case 'بازبینی':
                                $review++;
                                break;
                            case 'انجام شده':
                                $done++;
                                break;
                        }
                    @endphp
                @endforeach
            @endforeach


            <div class="workflow-board-container">
                <!-- Stage: To Do -->
                @if ($todo > 0)
                    <div class="workflow-stage">
                        <h3 class="stage-title"><i class="fas fa-inbox"></i> برای انجام <span class="task-count">({{ $todo }})</span></h3>
                        
                        <div class="stage-tasks" id="todo-tasks">
                            @foreach ($tasks as $item)
                               @foreach ($item -> tasks as $task)
                                    @if ($task -> status == 'برای انجام')
                                        <div class="task-card-horizontal" data-priority="high" data-project="alpha" data-assignee="DevLead">
                                            <a href="{{ route('task.view', ['id' => $task->id]) }}" class="task-card-title">{{ $task -> project_name }}</a>
                                            <div class="task-card-meta">
                                                <span class="badge badge-priority-{{ color_preference_style ($task -> preference) }}">{{ $task -> preference }}</span>
                                                <div class="task-card-assignee">
                                                    <div class="task-card-avatar" style="background-color: var(--danger-color);">
                                                    {{ $task -> undertaking }}
                                                    </div>
                                                    <span>{{ $task -> undertaking }}</span>
                                                </div>
                                                <div class="task-card-due-date"><i class="far fa-calendar-alt"></i><span>{{ $task->deadline->toDateString() }}</span></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div> 
                    </div>
                @endif

                <!-- Stage: In Progress -->
                @if ($progress > 0)
                    <div class="workflow-stage">
                        <h3 class="stage-title"><i class="fas fa-inbox"></i> در حال انجام <span class="task-count">({{ $progress }})</span></h3>
                        
                        <div class="stage-tasks" id="todo-tasks">
                             @foreach ($tasks as $item)
                               @foreach ($item -> tasks as $task)
                                    @if ($task -> status == 'در حال انجام')
                                        <div class="task-card-horizontal" data-priority="high" data-project="alpha" data-assignee="DevLead">
                                            <a href="{{ route('task.view', ['id' => $task->id]) }}" class="task-card-title">{{ $task -> project_name }}</a>
                                            <div class="task-card-meta">
                                                <span class="badge badge-priority-{{ color_preference_style ($task -> preference) }}">{{ $task -> preference }}</span>
                                                <div class="task-card-assignee">
                                                    <div class="task-card-avatar" style="background-color: var(--danger-color);">
                                                    {{ $task -> undertaking }}
                                                    </div>
                                                    <span>{{ $task -> undertaking }}</span>
                                                </div>
                                                <div class="task-card-due-date"><i class="far fa-calendar-alt"></i><span>{{ $task->deadline->toDateString() }}</span></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div> 
                    </div>
                @endif

                <!-- Stage: Review -->
                @if ($review > 0)
                    <div class="workflow-stage">
                        <h3 class="stage-title"><i class="fas fa-inbox"></i> بازبینی <span class="task-count">({{ $review }})</span></h3>
                        
                        <div class="stage-tasks" id="todo-tasks">
                             @foreach ($tasks as $item)
                               @foreach ($item -> tasks as $task)
                                    @if ($task -> status == 'بازبینی')
                                        <div class="task-card-horizontal" data-priority="high" data-project="alpha" data-assignee="DevLead">
                                            <a href="{{ route('task.view', ['id' => $task->id]) }}" class="task-card-title">{{ $task -> project_name }}</a>
                                            <div class="task-card-meta">
                                                <span class="badge badge-priority-{{ color_preference_style ($task -> preference) }}">{{ $task -> preference }}</span>
                                                <div class="task-card-assignee">
                                                    <div class="task-card-avatar" style="background-color: var(--danger-color);">
                                                    {{ $task -> undertaking }}
                                                    </div>
                                                    <span>{{ $task -> undertaking }}</span>
                                                </div>
                                                <div class="task-card-due-date"><i class="far fa-calendar-alt"></i><span>{{ $task->deadline->toDateString() }}</span></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div> 
                    </div>
                @endif

                <!-- Stage: Done -->
                @if ($done > 0)
                    <div class="workflow-stage">
                        <h3 class="stage-title"><i class="fas fa-inbox"></i> انجام شده <span class="task-count">({{ $done }})</span></h3>
                        
                        <div class="stage-tasks" id="todo-tasks">
                             @foreach ($tasks as $item)
                               @foreach ($item -> tasks as $task)
                                    @if ($task -> status == 'انجام شده')
                                        <div class="task-card-horizontal" data-priority="high" data-project="alpha" data-assignee="DevLead">
                                            <a href="{{ route('task.view', ['id' => $task->id]) }}" class="task-card-title">{{ $task -> project_name }}</a>
                                            <div class="task-card-meta">
                                                <span class="badge badge-priority-{{ color_preference_style ($task -> preference) }}">{{ $task -> preference }}</span>
                                                <div class="task-card-assignee">
                                                    <div class="task-card-avatar" style="background-color: var(--danger-color);">
                                                    {{ $task -> undertaking }}
                                                    </div>
                                                    <span>{{ $task -> undertaking }}</span>
                                                </div>
                                                <div class="task-card-due-date"><i class="far fa-calendar-alt"></i><span>{{ $task->deadline->toDateString() }}</span></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div> 
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection