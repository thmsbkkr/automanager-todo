import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import Task from './Task'
import TaskInput from './TaskInput'

export default class TodoApp extends Component {
  constructor() {
    super();

    this.state = {
      tasks: [],
      newTask: ''
    }

    this.add = this.add.bind(this)
    this.edit = this.edit.bind(this)
    this.cancel = this.cancel.bind(this)
    this.updateNewTask = this.updateNewTask.bind(this)
  }


  componentDidMount() {
    axios.get('/tasks')
      .then(res => res.data.data)
      .then(tasks => this.setState({ tasks }))
  }


  updateNewTask(newTask) {
    this.setState({ newTask })
  }


  add(task) {
    Axios
      .post('/tasks', task)
      .then(res => res.data.data)
      .then(task => this.setState(state => {
        const tasks = state.tasks.concat(task)

        return {
          tasks
        };
      }))

    this.setState({ newTask: '' })
  }


  save(task) {
    console.log('save')
  }


  toggle(taskToToggle) {
    Axios
      .post(`/tasks/${taskToToggle.id}/toggle`)
      .then(() => this.setState(state => {
        const tasks = state.tasks.map(function (task) {
          return task !== taskToToggle ? task : { ...task, completed: !task.completed }
        })

        return {
          tasks
        };
      }))
  }


  edit(task) {
    this.setState({ editing: task.id });
  }


  cancel() {
    this.setState({ editing: null });
  }


  render() {
    const tasks = this.state.tasks

    const mapTasks = (task) => {
      return (
        <Task
          key={task.id}
          task={task}
          editing={this.state.editing === task.id}
          onEdit={() => this.edit(task)}
          onSave={() => this.save(task)}
          onToggle={() => this.toggle(task)}
          onCancel={this.cancel}
        />
      )
    }

    const activeTasks = tasks
      .filter(task => task = !task.completed)
      .map(task => mapTasks(task))

    const completedTasks = tasks
      .filter(task => task = task.completed)
      .map(task => mapTasks(task))

    return (
      <div>
        <TaskInput
          value={this.state.newTask}
          onEnter={this.add}
          onUpdate={this.updateNewTask} />

        {activeTasks.length > 0 && (
          <div className="card mt-4">
            <div className="card-header">Active tasks</div>
            <ul className="list-group list-group-flush">
              {activeTasks}
            </ul>
          </div>
        )}

        {completedTasks.length > 0 && (
          <div className="card mt-4">
            <div className="card-header">Completed tasks</div>
            <ul className="list-group list-group-flush">
              {completedTasks}
            </ul>
          </div>
        )}
      </div>
    )
  }
}

if (document.getElementById('todo-app')) {
  ReactDOM.render(<TodoApp />, document.getElementById('todo-app'))
}
