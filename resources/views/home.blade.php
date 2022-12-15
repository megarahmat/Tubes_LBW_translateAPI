@extends('layout.main')

@section('container')
    <h1>LBW Transaltor</h1>
    
    <form>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Language</label>
            <textarea class="form-control" id="inputText" rows="3" placeholder="Insert Text"></textarea>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Result Language</label>
            <textarea class="form-control" id="googleResult" rows="3" placeholder="Translation "></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="btn_sumbit">Submit</button>
    </form>  
@endsection