# Automatic_Timetable_Manager_Backend
 
Backend for Automatic Timetable Manager Mobile Application


# The Scheduling Mechanism for Generating and Rearranging timetables

![image](https://user-images.githubusercontent.com/46781449/183228537-553d3934-37f0-4ef0-bc6a-8ec133211061.png)


The proposed mechanism require users to assign priority level for the tasks that they want to include in their timetable and arrange timetable according to the priority level of the tasks. Higher priority tasks will be assigned with more timeslot than the lower priority task and be put at the front of the queue list when assigning tasks to timetable. User can still input some constraints that are optional such as preferred time and preferred date for the task to help the system produce optimal solution, but this constraint will not have respective priority level as in the “constraint priorities” research.

Firstly, a list of new tasks within a target week chosen by user will be merged with the user’s list of assigned tasks within the target week from the database. Then, the list will be arranged in descending order according to the priority level of the tasks. The old timetable of the target week will be deleted to reschedule the timetable with the new tasks. 

A loop will be initiated to go through the list of tasks and assign each task with timeslot amount according to their respective priority level. If a task does not have a preferred date, a random date within the target week will be assigned to the task. Then, if there is not enough free timeslot left for the assigned date, the assigned date will be incremented by one day and checked again for timeslot availability for the day. 

If there is enough timeslot for the assigned date, and the task did not have a preferred timeslot, it will be randomly assigned to any free timeslot available for the day If the task had preferred timeslot, and the preferred timeslot is not occupied, it will be assigned to the preferred timeslot; Otherwise, the task will be randomly assigned to any free timeslot available for the day. The process will end once every task in the list is being looped through and assigned a timeslot. 
