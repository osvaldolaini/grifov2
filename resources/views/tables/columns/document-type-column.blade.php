<div>
    <div style="
        background-color: rgb(
        {{ $getRecord()->type->rgb_color[0]}},
         {{ $getRecord()->type->rgb_color[1]}},
          {{ $getRecord()->type->rgb_color[2]}},
          {{ $getRecord()->type->rgb_color[3]}}
          );
        border-color:rgb(
        {{ $getRecord()->type->rgb_color[0]}},
         {{ $getRecord()->type->rgb_color[1]}},
          {{ $getRecord()->type->rgb_color[2]}}
          );

          /* color:rgb(
        {{ $getRecord()->type->rgb_color[0]}},
         {{ $getRecord()->type->rgb_color[1]}},
          {{ $getRecord()->type->rgb_color[2]}}
          ); */
        "
        class="p-1 text-xs border rounded-md">
        {{ $getRecord()->type->nome}}
    </div>
</div>
