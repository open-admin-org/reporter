<style>
    .error-line{
         border-top: 2px #fff solid;
         padding: 10px 0px 10px 10px;
         background-color: #f3f3f3;
    }
    .list-group-name-value{
        width:100%;
        flex-wrap: wrap;
    }
    .list-group-name-value .list-group-item{
        border:none;
    }

    .list-group-name-value dt.list-group-item.name{
        width:200px;
    }
    .list-group-name-value dd.list-group-item.value{
        width: calc(100% - 200px);
    }

    .table.allow-wrap tr td{
        white-space:unset;

    }

</style>
<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">
            <h3 class="card-title"><i class="icon-info"></i>Request details</h3>
        </h3>

        <div class="card-tools">
            <a href="{{ route('exceptions.index') }}" class="btn btn-sm btn-primary"><i class="icon-list"></i>&nbsp;{{ trans('admin.list') }}</a>
        </div>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->

        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="accordion-item">
                <div class="accordion-header" role="tab" id="headingOne">
                    <a class="accordion-button show" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="icon-paper-plane">&nbsp;&nbsp;</i><strong>Request</strong>
                    </a>
                </div>
                <div id="collapseOne" class="accordion-body collapsed collapse show" role="tabpanel" aria-labelledby="headingOne">

                    <dl class="list-group list-group-horizontal list-group-name-value">
                        @if($exception->method)
                            <dt class="list-group-item name">method</dt>
                            <dd class="list-group-item value">{{ $exception->method }}</dd>
                        @endif

                        @if($exception->path)
                            <dt class="list-group-item name">url</dt>
                            <dd class="list-group-item value">{{ $exception->path }}</dd>
                        @endif

                        @if($exception->query)
                            <dt class="list-group-item name">query</dt>
                            <dd class="list-group-item value">{{ $exception->query }}</dd>
                        @endif

                        @if($exception->body)
                            <dt class="list-group-item name">body</dt>
                            <dd class="list-group-item value">{{ $exception->body }}</dd>
                        @endif
                    </dl>

                    <hr>

                    <dl class="list-group list-group-horizontal list-group-name-value">
                        <dt class="list-group-item name">time</dt>
                        <dd class="list-group-item value">{{ $exception->created_at }}</dd>
                        <dt class="list-group-item name">client ip</dt>
                        <dd class="list-group-item value">{{ $exception->ip }}</dd>
                    </dl>

                </div>
            </div>
            <div class="accordion-item">
                <div class="accordion-header" role="tab" id="headingOne">
                    <a class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="icon-server">&nbsp;&nbsp;</i><strong>Headers</strong>
                    </a>
                </div>

                <div id="collapseTwo" class="accordion-body collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <dl class="list-group list-group-horizontal list-group-name-value">
                        @foreach($headers as $name => $values)
                            <dt class="list-group-item name">{{ $name }}</dt>
                            @foreach($values as $value)
                                <dd class="list-group-item value">{{ $value }}</dd>
                            @endforeach
                        @endforeach
                    </dl>
                </div>
            </div>
             <div class="accordion-item">
                <div class="accordion-header" role="tab" id="headingThree">
                    <a class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        <i class="icon-database">&nbsp;&nbsp;</i><strong>Cookies</strong>
                    </a>
                </div>
                <div id="collapseThree" class="accordion-body collapse" role="tabpanel" aria-labelledby="headingThree">

                    <dl class="list-group list-group-horizontal list-group-name-value">
                        @foreach($cookies as $name => $value)
                            <dt class="list-group-item name">{{ $name }}</dt>
                            <dd class="list-group-item value">{{ $value }}</dd>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="card card-primary mt-4">
    <div class="card-header">
        <h3 class="card-title"><i class="icon-file-code"></i>Exception Trace</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="browser-window">

            @if ($exception->code || $exception->message)
                <table class="table allow-wrap args" style="margin: 0px;">
                    <tbody>
                    <tr>

                        <td style="width: 40px;">&nbsp;</td>
                        <td class="name"><strong>Exception</strong></td>
                        <td class="value"><code>{{ $exception->type }}</code></td>
                    </tr>
                    <tr>
                        @if ($exception->code)
                            <td style="width: 40px;">&nbsp;</td>
                            <td class="name"><strong>Code</strong></td>
                            <td class="value">{{ $exception->code }}</td>
                        @endif

                        @if ($exception->message)
                            <td style="width: 40px;">&nbsp;</td>
                            <td class="name"><strong>Message</strong></td>
                            <td class="value"><strong><em>{{ $exception->message }}</em></strong></td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            @endif

            @foreach($frames as $index => $frame)
                <div data-bs-toggle="collapse" data-bs-target="#frame-{{ $index }}" class="error-line">
                    <i class="icon-info" style="color: #4c748c;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0);">{{ str_replace(base_path() . '/', '', $frame->file()) }}</a>
                    in <a href="javascript:void(0);">{{ $frame->method() }}</a> at line <span class="badge bg-secondary">{{ $frame->line() }}</span>
                </div>
                <div class="window-content collapse {{ $index == 0 ? 'in' : '' }}" id="frame-{{ $index }}">
                    <pre data-start="{!! $frame->getCodeBlock()->getStartLine() !!}" data-line="{!! $frame->line()-$frame->getCodeBlock()->getStartLine()+1  !!} " class="language-php line-numbers"><code>{!! $frame->getCodeBlock()->output() !!}</code></pre>
                    <table class="table allow-wrap args" style="background-color: #FFFFFF; margin: 10px 0px 0px 0px;">
                        <tbody>
                        @foreach($frame->args() as $name => $val)
                            <tr>
                                <td style="width: 40px;">&nbsp;</td>
                                <td class="name"><strong>{{ $name }}</strong></td>
                                <td class="value">{{ $val }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @endforeach
        </div>

    </div>
</div>

