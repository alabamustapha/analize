@if(auth()->user()->isAdmin)
<div class="row">

        <div class="col-md-6">
        <h1 class="h2 mt-3">{{ $lab->name }} - {{ $title }}</h1>
        </div>
        <div class="col-md-6">
        
                <div class="dropdown mt-3">
                    <a class="btn btn-secondary dropdown-toggle float-right" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        {{ $lab->name }}
                    </a>
                
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('show_lab', ['lab' => $lab->slug]) }}">Dashboard</a>
                        <a class="dropdown-item" href="{{ route('edit_lab', ['lab' => $lab->slug]) }}">Edit {{ $lab->name }}</a>
                        <a class="dropdown-item" href="{{ route('show_lab_locations', ['lab' => $lab->slug]) }}">Manage Locations</a>
                        <a class="dropdown-item" href="{{ route('show_lab_tests', ['lab' => $lab->slug]) }}">Manage Tests</a>
                        <a class="dropdown-item" href="{{ route('link_lab_tests_to_group', ['lab' => $lab->slug]) }}">Link Tests</a>
                        <a class="dropdown-item" href="{{ route('manage_linked_lab_tests', ['lab' => $lab->slug]) }}">Manage Linked Tests</a>
                        <a class="dropdown-item" href="{{ route('edit_lab_bio', ['lab' => $lab->slug]) }}">Edit bio</a>
                        <a class="dropdown-item" href="{{ route('manage_lab_teams', ['lab' => $lab->slug]) }}">Manage Teams</a>
                        <a class="dropdown-item" href="{{ route('manage_lab_packages', ['lab' => $lab->slug]) }}">Manage Packages</a>
                        <a class="dropdown-item" href="{{ route('manage_lab_gallery', ['lab' => $lab->slug]) }}">Manage Gallery</a>
                    </div>
                </div>
            
        </div>
    
    </div>
@else

<div class="mt-3"></div>
@endif    