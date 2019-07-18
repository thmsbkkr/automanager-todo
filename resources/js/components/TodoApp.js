import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import TaskList from './TaskList'
import TaskInput from './TaskInput'

export default class TodoApp extends Component {
  constructor() {
    super();

    this.state = { tasks: [] }

    this.addTask = this.addTask.bind(this)
  }

  componentDidMount() {
    axios.get('/tasks')
      .then(res => res.data.data)
      .then(tasks => this.setState({ tasks }))
  }

  addTask (task) {
    axios.post('/tasks', task)
    .then(res => res.data.data)
    .then(task => this.setState(state => {
        const tasks = state.tasks.concat(task)

        return {
          tasks
        };
      })
    )
  }

  render() {
    return (
      <div>
        <TaskInput addTask={this.addTask}/>

        <TaskList tasks={this.state.tasks} />
      </div>
    )
  }
}

if (document.getElementById('todo-app')) {
  ReactDOM.render(<TodoApp />, document.getElementById('todo-app'))
}
