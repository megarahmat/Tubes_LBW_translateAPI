@extends('layout.main')

@section('container')
    <h1>LBW Transaltor</h1>
    
    <form action="/getTranslate" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Language</label>

            <select name="input_bahasa" id="bahasa" required>
                <option value="">Pilih Bahasa</option>
                @foreach ($bahasa as $res)
                    <option value="{{$res['code']}}">
                        {{$res['name']}}
                    </option>
                @endforeach
            </select>

            <textarea class="form-control w-50 p-3" id="inputText" rows="3" placeholder="Insert Text" name="input_text"  required ></textarea>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label" >Target Language</label>
            <select name="target_bahasa" id="bahasa" required>
                <option value="">Pilih Bahasa</option>
                @foreach ($bahasa as $res)
                    <option value="{{$res['code']}}">
                        {{$res['name']}}
                    </option>
                @endforeach
            </select>
            <div class="d-flex justify-content-xl-start">
                <div class="p-2">
                    <textarea class="form-control " id="googleResult" rows="5" placeholder="Google Translation" readonly></textarea>

                </div>
                <div class="p-2">
                    
                    <textarea class="form-control " id="microsoftResult" rows="5" placeholder="Microsft Translation" readonly></textarea>
                </div>
                <div class="p-2">
                    <textarea class="form-control " id="textTranslatorResult" rows="5" placeholder="Text Translator Translation" readonly></textarea>

                </div>
              </div>    


            
            
            
        </div>
        
        <input  type="submit" class="btn btn-primary" id="btn_sumbit" value="Transalte">
    </form>  

    
@endsection