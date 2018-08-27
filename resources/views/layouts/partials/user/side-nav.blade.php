<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        
        <li class="nav-item">
          <a class="nav-link {{ isActiveRoute('user_show_lab') ? 'active' : '' }}" href="{{ route('user_show_lab', ['lab' => $lab->slug]) }}">
              <span data-feather="home"></span>
              {{ $lab->name }} <span class="sr-only">(current)</span>
            </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_edit_lab', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Edit {{ $lab->name }}
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_show_lab_locations', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Manage Locations
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_show_lab_tests', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Manage Tests
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_link_lab_tests_to_group', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Link Tests
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_manage_linked_lab_tests', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Manage Linked Tests
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_edit_lab_bio', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Edit bio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_manage_lab_teams', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Manage Teams
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_manage_lab_packages', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Manage Packages
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user_manage_lab_gallery', ['lab' => $lab->slug]) }}">
            <span data-feather="home"></span> Manage Gallery
          </a>
        </li>
        
        
      </ul>

    </div>
  </nav>