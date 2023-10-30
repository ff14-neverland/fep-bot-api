<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('header')
<body>
  @include('menu')
  <div class="main-content">
    <div class="card">
      <div class="card-header">
        查询角色状态
      </div>
      <div class="card-body">
        <form action="/ui/status" method="post">
          <div class="form-group">
            <label for="chara1">角色名称</label>
            <input type="text" class="form-control" name="chara" id="chara" placeholder="输入角色名称">
          </div>
          <button type="submit" class="btn btn-primary">查询</button>
        </form>
      </div>
    </div>
    <div class="card chara-status">
      <div class="card-header">
        角色状态
      </div>
      <div class="card-body">
        @if (isset($status_info))
          <div class="status-text">
              <h3>能力值</h3>
              {{ $status_info['full_text']}}
          </div>
          <div class="status-text">
              <h3>支援</h3>
              {{ $status_info['支援']}}
          </div>
          <div class="status-text">
              <h3>其他</h3>
              {{ $status_info['其他']}}
          </div>
        @endif
      </div>
    </div>
  </div>
</body>
</html>
