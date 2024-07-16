<div class="bg-white shadow-md dark:bg-gray-800 pt-3 sm:rounded-lg">
    @if ($docPdf)    
        <div class="w-full h-full flex mt-1">
            <object class="w-full h-[50rem]" data="{{url('storage/attachments/docs/'.$this->doc->id.'/'.$this->doc->id.'.pdf')}}" 
            type="application/pdf">
            </object>
        </div>
    @else
        <div class="w-full flex mt-1">
            nenhum documento encontrado
        </div>
    @endif
</div>