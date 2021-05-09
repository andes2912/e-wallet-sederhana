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
    <form action="{{url('logic')}}" method="post">
      @csrf
      <div class="col-lg-6 mt-4">
        <div class="form-group">
          <label for="Number">Number</label>
            <input type="text" class="form-control" name="number" required placeholder="Number">
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>

    </form>
  </div>
</body>
@include('logic.script')
</html>