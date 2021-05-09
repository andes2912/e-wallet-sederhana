<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Logic</title>
  @include('logic.style')
</head>
<body>
  <div class="container">
    <div class="col-12 mt-5 row">
      <div class="col-4">
        <form action="{{url('logic-reject')}}" method="post">
          @csrf
            <div class="form-group">
              <label for="Number">Number Reject</label>
                <input type="text" class="form-control" name="number" required placeholder="Number">
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>

      <div class="col-4">
        <form action="{{url('logic-tengah')}}" method="post">
          @csrf
            <div class="form-group">
              <label for="Number">Number Tengah</label>
                <input type="text" class="form-control" name="number" required placeholder="Number">
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>

       <div class="col-4">
        <form action="{{url('logic-kiri')}}" method="post">
          @csrf
            <div class="form-group">
              <label for="Number">Number Kiri</label>
                <input type="text" class="form-control" name="number" required placeholder="Number">
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Number</th>
          <th scope="col">Posisi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; ?>
        @foreach ($data as $item)
          <tr>
            <th scope="row">{{$no}}</th>
            <td>{{$item->number}}</td>
            <td>{{$item->posisi}}</td>
          </tr>
        <?php $no++; ?>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
@include('logic.script')
</html>