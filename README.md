# timetable
Updated version of guide-scheduler with web

The folder TimeTable contains the graph-theory based scheduling algorithm. There are four main classes.

<ul>
  <li><b>Node:</b> parent class to encompass the two different types of nodes (item and block)</li>
  <li><b>Item:</b> items are scheduled -- contain availabilities</li>
  <li><b>Block:</b> blocks are the possible availabilities</li>
  <li><b>Graph:</b> contains item and block nodes in order to run the Ford Fulkerson algorithm</li>
</ul>

<b>matcher.cpp</b> contains the heart of the algorithm</br>
<b>timetable.cpp</b> is the entry point of the application
